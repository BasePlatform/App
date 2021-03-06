<?php
/*
 * This file is part of the BasePlatform project.
 *
 * @link https://github.com/BasePlatform
 * @license https://github.com/BasePlatform/Base/blob/master/LICENSE.txt
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Base\Db\Adapter;

use Base\Db\DbAdapterInterface;
use InvalidArgumentException;
use RuntimeException;

/**
 * Master Slave PDO Proxy supports Master-Slave Database Cluster Connections
 * and select the connection based on the query
 *
 * It also helps not to create a connection before actual usage
 *
 * Original source - https://github.com/voduytuan/litpi-framework-3/blob/master/src/Vendor/Litpi/MyPdoProxy.php
 *
 * @package Base\Db\Adapter
 */
class MasterSlavePDO implements DbAdapterInterface
{
    /**
     * @var array Connection Definitions
     */
    protected $connections = [];

    /**
     * @var array Connected Connections
     */
    protected $connectedConnections = [];

    /**
     * @var array Master Connections
     */
    protected $masters = [];

    /**
     * @var array Slave Connections
     */
    protected $slaves = [];

    /**
     * @var \PDO
     */
    protected $latestReplicateDb = null;

    /**
     * @var array \PDO Options
     */
    protected $options = [];

    /**
     * @var bool inTransaction
     */
    protected $inTransaction = false;

    /**
     * @param array $options
     */
    public function __construct(array $options)
    {
        if (!empty($options)) {
            $this->options = $options;
        } else {
            $this->options =  [
            \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
            \PDO::ATTR_EMULATE_PREPARES   => false,
            ];
        }
    }

    /**
     * {@inheritdoc}
     */
    public function errorCode()
    {
        if ($this->latestReplicateDb) {
            return $this->latestReplicateDb->errorCode();
        }
        throw new RuntimeException('No Living Connection');
    }

    /**
     * {@inheritdoc}
     */
    public function errorInfo()
    {
        if ($this->latestReplicateDb) {
            return $this->latestReplicateDb->errorInfo();
        }
        throw new RuntimeException('No Living Connection');
    }

    /**
     * {@inheritdoc}
     */
    public function exec(string $statement)
    {
        $this->latestReplicateDb = $replicateDb = $this->selectReplicateDbAutomatically($statement);
        return $replicateDb->exec($statement);
    }

    /**
     * {@inheritdoc}
     */
    public function prepare(string $statement, array $options = null)
    {
        $this->latestReplicateDb = $replicateDb = $this->selectReplicateDbAutomatically($statement);
        return $replicateDb->prepare($statement, $options);
    }

    /**
     * {@inheritdoc}
     */
    public function quote(string $string, int $paramer_type = \PDO::PARAM_STR)
    {
        $this->latestReplicateDb = $replicateDb = $this->getAReplicateDb('slave');
        return $replicateDb->quote($string, $paramer_type);
    }

    /**
     * {@inheritdoc}
     */
    public function query(string $statement)
    {
        $this->latestReplicateDb = $replicateDb = $this->selectReplicateDbAutomatically($statement);
        return $replicateDb->query($statement);
    }

    /**
     * {@inheritdoc}
     */
    public function lastInsertId($name = null)
    {
        if ($this->latestReplicateDb) {
            return $this->latestReplicateDb->lastInsertId($name);
        }
        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function beginTransaction()
    {
        $this->latestReplicateDb = $replicateDb = $this->getAReplicateDb('master');
        $result = $replicateDb->beginTransaction();
        if ($result) {
            $this->inTransaction = true;
        }
        return $result;
    }

    /**
     * {@inheritdoc}
     */
    public function commit()
    {
        if ($this->latestReplicateDb) {
            return $this->latestReplicateDb->commit();
        }
        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function rollBack()
    {
        if ($this->latestReplicateDb) {
            return $this->latestReplicateDb->rollBack();
        }
        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function inTransaction()
    {
        return $this->inTransaction;
    }

    /**
     * {@inheritdoc}
     */
    public function addMaster(array $config, array $options = [])
    {
        $host = $config['host'] ?? '';
        $port = isset($config['port']) ? (string)$config['port'] : '3306';
        $database = $config['database'] ?? '';
        $username = $config['username'] ?? '';
        $password = $config['password'] ?? '';
        $options = empty($options) ? $this->options : $options;
        if (empty($host)) {
            throw new InvalidArgumentException('Missing Master DB Host Config');
        }
        if (empty($database)) {
            throw new InvalidArgumentException('Missing Master DB Database Config');
        }
        if (empty($username)) {
            throw new InvalidArgumentException('Missing Master DB User Config');
        }
        // Create connection identifier
        $identifier = md5($host.$port.$database.$username.$password);
        $this->connections['master'][$identifier] = [
          'identifier' => $identifier,
          'host' => $host,
          'port' => $port,
          'database' => $database,
          'username' => $username,
          'password' => $password,
          'options' => $options
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function addSlave(array $config, array $options = [])
    {
        $host = $config['host'] ?? '';
        $port = isset($config['port']) ? (string)$config['port'] : '3306';
        $database = $config['database'] ?? '';
        $username = $config['username'] ?? '';
        $password = $config['password'] ?? '';
        $options = empty($options) ? $this->options : $options;
        if (empty($host)) {
            throw new InvalidArgumentException('Missing Slave DB Host Config');
        }
        if (empty($database)) {
            throw new InvalidArgumentException('Missing Slave DB Database Config');
        }
        if (empty($username)) {
            throw new InvalidArgumentException('Missing Slave DB User Config');
        }
        // Create connection identifier
        $identifier = md5($host.$port.$database.$username.$password);
        $this->connections['slave'][$identifier] = [
          'identifier' => $identifier,
          'host' => $host,
          'port' => $port,
          'database' => $database,
          'username' => $username,
          'password' => $password,
          'options' => $options
        ];
    }

    /**
     * Init Connection
     *
     * @param  string $mode
     * @param  string $identifier
     *
     * @return \PDO|null
     *
     */
    public function initConnection(string $identifier, string $mode = 'master')
    {
        $replicate = $mode == 'master' ? 'master' : 'slave';
        if (!isset($this->connectedConnections[$replicate . '-' . $identifier])) {
            try {
                if ($mode == 'master') {
                    $dsn = 'mysql:dbname='.$this->connections['master'][$identifier]['database'].';host='.$this->connections['master'][$identifier]['host'].';port='.$this->connections['master'][$identifier]['port'];
                    $this->masters[$identifier] = new \PDO(
                        $dsn,
                        $this->connections['master'][$identifier]['username'],
                        $this->connections['master'][$identifier]['password'],
                        $this->connections['master'][$identifier]['options']
                    );
                    $this->masters[$identifier]->query('SET NAMES utf8');
                } else {
                    $dsn = 'mysql:dbname='.$this->connections['slave'][$identifier]['database'].';host='.$this->connections['slave'][$identifier]['host'].';port='.$this->connections['slave'][$identifier]['port'];
                    $this->slaves[$identifier] = new \PDO(
                        $dsn,
                        $this->connections['slave'][$identifier]['username'],
                        $this->connections['slave'][$identifier]['password'],
                        $this->connections['slave'][$identifier]['options']
                    );
                    $this->slaves[$identifier]->query('SET NAMES utf8');
                }
                //mark as connect to this replicate
                $this->connectedConnections[$replicate . '-' . $identifier] = true;
            } catch (\PDOException $e) {
                throw new \RuntimeException('Error Establishing Database Connection');
            }
        } //end check connection
        $db = null;
        if (isset($this->connectedConnections[$replicate . '-' . $identifier])
        && $this->connectedConnections[$replicate . '-' . $identifier]) {
            if ($mode == 'master') {
                if (!empty($this->masters[$identifier])) {
                    $db = $this->masters[$identifier];
                }
            } else {
                if (!empty($this->slaves[$identifier])) {
                    $db = $this->slaves[$identifier];
                }
            }
        }
        return $db;
    }

    /**
     * Get a Relicate DB Based on the mode
     *
     * If it is in transaction, and there is a latestReplicateDb, it will return that instance. Otherwise, it will call initConnection function
     *
     * @param  string $mode
     *
     * @return \PDO
     *
     */
    public function getAReplicateDb(string $mode = 'master')
    {
        // If inTransaction and we have made a connection, return that
        if ($this->inTransaction && $this->latestReplicateDb) {
            return $this->latestReplicateDb;
        }

        $replicateCount = count($this->connections[$mode]);
        //select a db
        if ($replicateCount == 0) {
            throw new InvalidArgumentException('DB '.$mode.' Config Not Found');
        } else {
            // Select a random connection
            $randomconnections = [];
            $randseed = rand(1, $replicateCount);
            $i = 1;
            foreach ($this->connections[$mode] as $connections) {
                if ($i == $randseed) {
                    $randomconnections = $connections;
                }
                $i++;
            }
            return $this->initConnection($randomconnections['identifier'], $mode);
        }
    }

    /**
     * Automatically select a Replicate Db master or slave based on the sql query
     * If it is in transaction, it returns a Master
     *
     * @param  string $sql
     *
     * @return \PDO
     *
     */
    public function selectReplicateDbAutomatically(string $sql)
    {
        // Check for case in transaction
        if ($this->inTransaction) {
            return $this->getAReplicateDb('master');
        }
        $sql = trim($sql);
        if (stripos($sql, 'SELECT') === 0) {
            $db = $this->getAReplicateDb('slave');
        } else {
            $db = $this->getAReplicateDb('master');
        }
        return $db;
    }

    /**
     * {@inheritdoc}
     */
    public function __destruct()
    {
        foreach ($this->masters as $pdoObject) {
            $pdoObject = null;
            unset($pdoObject);
        }
        foreach ($this->slaves as $pdoObject) {
            $pdoObject = null;
            unset($pdoObject);
        }
    }
}
