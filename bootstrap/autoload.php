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
 * Define services uri
 *
 * If a service uri is not defined when needed, the system will use
 * the default service uri for making a service request
 */
$protocol = strtolower(substr($_SERVER["SERVER_PROTOCOL"], 0, 5)) == 'https' ? 'https' : 'http';

define('SERVICE_DEFAULT_URI', env('SERVICE_DEFAULT_URI', $protocol.$_SERVER['HTTP_HOST']));
/*
 * Uncomment and edit if you want to define custom uri per service
 */
// define('TENANT_SERVICE_URI', SERVICE_DEFAULT_URI);
// define('APP_SERVICE_URI', SERVICE_DEFAULT_URI);
// define('AUTH_SERVICE_URI', SERVICE_DEFAULT_URI);
