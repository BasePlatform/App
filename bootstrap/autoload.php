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