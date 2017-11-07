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

// Define the SERVICES CONSTANTS
foreach ($config->get('constants') as $key => $value) {
    define($key, $value);
}

// Set Default TimeZone
$timeZone = $config->get('timeZone');
if (!$timeZone) {
    $timeZone = 'UTC';
}
date_default_timezone_set($timeZone);

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

$serviceRequest = new Base\ServiceRequest\ServiceRequest($config->get('endpoints'));
$container->share($serviceRequest);

$container->alias(Base\Http\ResponseFactoryInterface::class, Base\Http\ResponseFactory::class);
$container->alias(Psr\Log\LoggerInterface::class, Monolog\Logger::class);
$container->alias(Base\ServiceRequest\ServiceRequestInterface::class, Base\ServiceRequest\ServiceRequest::class);

$container->alias(Base\PDO\PDOProxyInterface::class, Base\PDO\PDOProxy::class);
$container->alias(Base\TenantService\Repository\TenantRepositoryInterface::class, Base\TenantService\Repository\TenantRepository::class);
$container->alias(Base\TenantService\Service\TenantServiceInterface::class, Base\TenantService\Service\TenantService::class);

// Factory
$container->alias(Base\TenantService\Factory\TenantFactoryInterface::class, Base\TenantService\Factory\TenantFactory::class);

$container->define(Base\TenantService\Factory\TenantFactory::class, [':factory' => new Base\Factory\Factory(Base\TenantService\Entity\Tenant::class)]);


// Entity
$container->alias(Base\TenantService\Entity\TenantInterface::class, Base\TenantService\Entity\Tenant::class);

// Value Object
$container->alias(Base\TenantService\ValueObject\TenantIdInterface::class, Base\TenantService\ValueObject\TenantId::class);

// Define some params
$container->define(Base\TenantService\Controller\TenantController::class, [':domain' => $config->get('domain'), ':platform' => $config->get('platform')]);


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

return $container;
