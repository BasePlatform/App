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

/**
 * Setup error mode
 */
error_reporting(E_ALL & ~E_USER_DEPRECATED & ~E_DEPRECATED & ~E_STRICT & ~E_NOTICE);

/**
 * Set time of app start
 */
define('APP_START', microtime(true));

/**
 * Include vendor autoload
 */
require __DIR__.'/../vendor/autoload.php';

/**
 * Load the environment variables
 */
$dotenv = new Dotenv\Dotenv(__DIR__ . '/..');
$dotenv->load();

/**
 * Get Config object
 */
$config = require __DIR__ . '/../config/config.php';

/**
 * Set to Base\Service::$config as config registry for future access
 */
\Base\Service::$config = $config;

/**
 * Define SERVICE CONSTANTS
 */
foreach ($config->get('constants') as $key => $value) {
    define($key, $value);
}

/**
 * Set Default Time Zone
 */
$timeZone = $config->get('timeZone');
if (!$timeZone) {
    $timeZone = 'UTC';
}
date_default_timezone_set($timeZone);

/**
 * Define services url
 *
 * If a service uri is not defined when needed, the system will use
 * the default service url for making a service request
 */
$protocol = strtolower(substr($_SERVER["SERVER_PROTOCOL"], 0, 5)) == 'https' ? 'https' : 'http';

define('SERVICE_DEFAULT_URL', env('SERVICE_DEFAULT_URL', $protocol.$_SERVER['HTTP_HOST']));

/*
 * Uncomment and edit if you want to define custom url per service
 */
// define('TENANT_SERVICE_URL', SERVICE_DEFAULT_URL);
// define('APP_SERVICE_URL', SERVICE_DEFAULT_URL);
// define('AUTH_SERVICE_URL', SERVICE_DEFAULT_URL);
