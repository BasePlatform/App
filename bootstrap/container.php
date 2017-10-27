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

use Psr\Log\LoggerInterface;

/**
 * Get Config object
 */
$config = require __DIR__ . '/../config/config.php';

/**
 * Create a container
 *
 * You can use other containers such as:
 * + Aura.DI
 * + Pimple
 * + PHP-DI
 */
$container = new Auryn\Injector;

/**
 * Add $config to the container for future use
 */
$container->share($config);

/**
 * Set some aliases based on the characteristics of
 * the app and container
 */
$container->alias(Base\Http\ResponseFactoryInterface::class, Base\Http\ResponseFactory::class);
$container->alias(Psr\Log\LoggerInterface::class, Monolog\Logger::class);

$container->alias(Base\PDO\PDOProxyInterface::class, Base\PDO\PDOProxy::class);
$container->alias(Base\TenantService\Repository\TenantRepositoryInterface::class, Base\TenantService\Repository\TenantRepository::class);
$container->alias(Base\TenantService\Service\TenantServiceInterface::class, Base\TenantService\Service\TenantService::class);

// Define some params
$container->define('Base\TenantService\Controller\TenantController', [':domain' => $config->get('domain')]);

/**
 * Create a logger and register it with the container
 */
$logger = new Monolog\Logger('logger');
// Setup handler for the logger
$logger->pushHandler(new Monolog\Handler\ErrorLogHandler());
$container->share($logger);

/**
 * Setup the PDO for MySQL
 */
$dbConfig = $config->get('db');

$mysqlConfig = isset($dbConfig['mysql']) ? $dbConfig['mysql'] : [];
if (!empty($mysqlConfig)) {
  $pdoOptions = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
  ];
  $pdo = new Base\PDO\PDOProxy($pdoOptions);
  $pdo->addMaster($mysqlConfig['master']['m1']);
  $pdo->addSlave($mysqlConfig['slave']['s1']);
  // Share it
  $container->share($pdo);
}


// if (!empty($dbConfig)) {
//   $pdoOptions = [
//     PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
//     PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
//     PDO::ATTR_EMULATE_PREPARES   => false,
//   ];
//   $container->share('PDO');
//   $container->define('PDO', [
//     ':dsn' => 'mysql:dbname='.$dbConfig['database'].';host='.$dbConfig['host'].';port='.$dbConfig['port'],
//     ':username' => $dbConfig['username'],
//     ':passwd' => $dbConfig['password'],
//     ':options' => $pdoOptions
//   ]);

//   // $pdo = new PDO('mysql:host='.$dbConfig['host'].';dbname='.$dbConfig['dbname'], $dbConfig['user'], $dbConfig['password'], $pdoOptions);
//   // $container->share($pdo);
// }

return $container;