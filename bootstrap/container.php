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

$container->alias(Base\TenantService\Service\TenantServiceInterface::class, Base\TenantService\Service\TenantService::class);

/**
 * Create a logger and register it with the container
 */
$logger = new Monolog\Logger('logger');
// Setup handler for the logger
$logger->pushHandler(new Monolog\Handler\ErrorLogHandler());
$container->share($logger);

/**
 * Setup the PDO
 */
$dbConfig = $config->get('db');
$dbConfig = isset($dbConfig['mysql']) ? $dbConfig : [];
if (count($dbConfig) > 0) {
  $container->share('PDO');
  $container->define('PDO', [
    ':dsn' => 'mysql:dbname='.$dbConfig['dbname'].';host='.$dbConfig['host'],
    ':username' => $dbConfig['user'],
    ':passwd' => $dbConfig['password']
  ]);
}

return $container;