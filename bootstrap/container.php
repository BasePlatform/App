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
 * Create a container
 *
 */
$container = new Auryn\Injector;

/**
 * Set some definitions based on the characteristics of
 * the app and container
 */

$dependencies = \Base\Service::$config->get('dependencies');

// Loop through definitions and set
if (isset($dependencies['definitions']) && !empty($dependencies['definitions'])) {
    foreach ($dependencies['definitions'] as $key => $value) {
        $container->alias($key, $value);
    }
}

// Loop through params and set
if (isset($dependencies['params']) && !empty($dependencies['params'])) {
    foreach ($dependencies['params'] as $key => $value) {
        if (is_callable($value)) {
            // Check the required params of the function
            $params = $value($container, $config);
        }
        if (is_array($value)) {
            $params = $value;
        }
        // We expect the returned $params is array
        if ($params && is_array($params) && !empty($params)) {
            foreach ($params as $paramKey => $paramValue) {
                $params[':'.$paramKey] = $paramValue;
                unset($params[$paramKey]);
            }
            $container->define($key, $params);
        }
    }
}

/**
 * Define service request with list of required endpoints
 */
$serviceRequest = new Base\ServiceRequest\ServiceRequest(\Base\Service::$config->get('requiredEndpoints'));
$container->share($serviceRequest);

/**
 * Define for security
 */
$security = new Base\Security\Security();
$container->share($security);

/**
 * Define for validator
 */
$validator = new Base\Validator\RespectValidator();
$container->share($validator);

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
$dbConfig = \Base\Service::$config->get('database.mysql');
if (!empty($dbConfig)) {
    $pdoOptions = [
      PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
      PDO::ATTR_EMULATE_PREPARES   => false,
    ];
    $pdo = new Base\PDO\PDOProxy($pdoOptions);
    $pdo->addMaster($dbConfig['master']['m1']);
    $pdo->addSlave($dbConfig['slave']['s1']);
    // Share it
    $container->share($pdo);
}

return $container;
