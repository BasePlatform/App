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

$dependencies = $config->get('dependencies');

// Loop through aliases and set
if (isset($dependencies['aliases']) && !empty($dependencies['aliases'])) {
    foreach ($dependencies['aliases'] as $key => $value) {
        $container->alias($key, $value);
    }
}

// Loop through params and set
if (isset($dependencies['params']) && !empty($dependencies['params'])) {
    foreach ($dependencies['params'] as $key => $value) {
        if (is_callable($value)) {
            $container->define($key, call_user_func($value));
        } else {
            $container->define($key, $value);
        }
    }
}

// Define some params
// $container->define(Base\TenantService\Controller\Site\RegisterTenantAction::class, [':appConfig' => $config->get('app')]);


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
