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

namespace Base\PDO;

use \PDO as PDO;
use InvalidArgumentException;
use Base\Exception\ServerErrorException;

/**
 * PDO Proxy supports Master-Slave Database Cluster Connections
 * and select the connection based on the query
 *
 * It also helps not to create a connection before actual usage
 *
 * Original source - https://github.com/voduytuan/litpi-framework-3/blob/master/src/Vendor/Litpi/MyPdoProxy.php
 *
 * @package Base\PDO
 */
class PDOProxy implements PDOProxyInterface
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
   * @var array PDO Options
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
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
            ];
        }
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
   * {@inheritdoc}
   */
    public function prepare(string $sql)
    {
        $this->latestReplicateDb = $replicateDb = $this->selectReplicateDbAutomatically($sql);
        $stmt = $replicateDb->prepare($sql);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        return $stmt;
    }

  /**
   * {@inheritdoc}
   */
    public function query(string $sql, array $params = [])
    {
        $this->latestReplicateDb = $replicateDb = $this->selectReplicateDbAutomatically($sql);
        $stmt = $replicateDb->query($sql, $params);
        return $stmt;
    }

  /**
   * {@inheritdoc}
   */
    public function __call($method, $args)
    {
        if ($this->latestReplicateDb && is_callable([$this->latestReplicateDb, $method])) {
            return call_user_func_array([$this->latestReplicateDb, $method], $args);
        } else {
            return false;
        }
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
                throw new ServerErrorException('Internal Server Error - DxB');
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
      // If inTransaction and we have made a connection
      // Return that
        if ($this->inTransaction && $this->latestReplicateDb) {
            return $this->latestReplicateDb;
        }

        $replicateCount = count($this->connections[$mode]);
      //select slave
        if ($replicateCount == 0) {
            throw new InvalidArgumentException('DB '.$mode.' Config Not Found');
        } else {
          // Select a random slave info
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
   * Initiates a transaction
   *
   * @link http://php.net/manual/pdo.begintransaction.php
   * @return bool <b>TRUE</b> on success or <b>FALSE</b> on failure.
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
   * Commits a transaction
   *
   * @link http://php.net/manual/pdo.commit.php
   * @return bool <b>TRUE</b> on success or <b>FALSE</b> on failure.
   */
    public function commit()
    {
        $this->latestReplicateDb = $replicateDb = $this->getAReplicateDb('master');
        $result = $replicateDb->commit();
        if ($result) {
            $this->inTransaction = true;
        }
        return $result;
    }

  /**
   * Rolls back a transaction
   *
   * @link http://php.net/manual/pdo.rollback.php
   * @return bool <b>TRUE</b> on success or <b>FALSE</b> on failure.
   */
    public static function rollBack()
    {
        $this->latestReplicateDb = $replicateDb = $this->getAReplicateDb('master');
        $result = $replicateDb->rollBack();
        if ($result) {
            $this->inTransaction = true;
        }
        return $result;
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
