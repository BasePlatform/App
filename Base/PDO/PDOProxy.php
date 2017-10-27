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
     * @param array $options
     */
    public function __construct(array $options)
    {
        if(!empty($options)) {
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
        $this->latestReplicateDb = $replicateDb = $this->getReplicateDb($sql);
        $stmt = $replicateDb->prepare($sql);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        return $stmt;
    }

    /**
     * {@inheritdoc}
     */
    public function query(string $sql, array $params = [])
    {
        $this->latestReplicateDb = $replicateDb = $this->getReplicateDb($sql);
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
     * {@inheritdoc}
     */
    public function initConnection($isMaster, $identifier)
    {
        $replicate = $isMaster ? 'master' : 'slave';
        if (!isset($this->connectedConnections[$replicate . '-' . $identifier])) {
            try {
                if ($isMaster) {
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
            if ($isMaster) {
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
     * {@inheritdoc}
     */
    public function getReplicateDb(string $sql)
    {
        $sql = trim($sql);
        if (stripos($sql, 'SELECT') !== 0) {
            //Not select query
            if (preg_match('/insert\s+into\s+([a-z0-9_]+)/ims', $sql, $match)) {
                $table = $match[1];
                $querytype = 'INSERT';
            } elseif (preg_match('/update\s+([a-z0-9_]+)/ims', $sql, $match)) {
                $table = $match[1];
                $querytype = 'UPDATE';
            } elseif (preg_match('/delete\s+from\s+([a-z0-9_]+)/ims', $sql, $match)) {
                $table = $match[1];
                $querytype = 'DELETE';
            } else {
                $querytype = 'OTHER';
            }
        } else {
            $querytype = 'SELECT';
            if (preg_match('/^select.*?from\s+([a-z0-9_]+)/ims', $sql, $match)) {
                $table = $match[1];
            }
        }
        //////////////////////
        // SELECT DB BASE ON QUERY TYPE
        if ($querytype == 'SELECT') {
            $replicateCount = count($this->connections['slave']);
            //select slave
            if ($replicateCount == 0) {
                throw new InvalidArgumentException('Slave DB Config Not Found');
            } else {
                // Select a random slave info
                $randomconnections = array();
                $randseed = rand(1, $replicateCount);
                $i = 1;
                foreach ($this->connections['slave'] as $connections) {
                    if ($i == $randseed) {
                        $randomconnections = $connections;
                    }
                    $i++;
                }
                $db = $this->initConnection(false, $randomconnections['identifier']);
            }
        } else {
            $replicateCount = count($this->connections['master']);
            if ($replicateCount == 0) {
                throw new InvalidArgumentException('Master DB Config Not Found');
            } else {
                // Select a random master info
                $randomconnections = array();
                $randseed = rand(1, $replicateCount);
                $i = 1;
                foreach ($this->connections['master'] as $connections) {
                    if ($i == $randseed) {
                        $randomconnections = $connections;
                    }
                    $i++;
                }
                $db = $this->initConnection(true, $randomconnections['identifier']);
            }
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