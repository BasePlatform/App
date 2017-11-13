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
 * Main application params
 */
return [
  'basePath' => dirname(__DIR__),
  'passwordHashCost' => env('PASSWORD_HASH_COST', 13),
  'app' => [
    'id' => 'base-app',
    'debug' => env('APP_DEBUG', false),
    'domain' => env('APP_DOMAIN', '.base.platform'),
    'platform' => env('APP_PLATFORM', null),
    'defaultInstallAppId' => env('APP_INSTALL_DEFAULT_ID', 'default'),
    'trialDays' => 14, // -1: No Trial, >= 0: Actual Trial Days
    // Secret 32 Characters Key
    'key' => env('APP_KEY', 'secret'),
    'env' => env('APP_ENV', 'production'),
    'timeZone' => 'UTC',
    'locale' => 'en',
  ],
  'database' => [
    'mysql' => [
      'master' => [
        'm1' => [
          'driver' => 'pdo_mysql',
          'database' => env('DB_MYSQL_DATABASE', 'Base'),
          'username' => env('DB_MYSQL_USERNAME', 'admin'),
          'password' => env('DB_MYSQL_PASSWORD', 'admin123'),
          'host' => env('DB_MYSQL_HOST', '172.17.0.1'),
          'port' => env('DB_MYSQL_PORT', '3306')
        ]
      ],
      'slave' => [
        's1' => [
          'driver' => 'pdo_mysql',
          'database' => env('DB_MYSQL_DATABASE', 'Base'),
          'username' => env('DB_MYSQL_USERNAME', 'admin'),
          'password' => env('DB_MYSQL_PASSWORD', 'admin123'),
          'host' => env('DB_MYSQL_HOST', '172.17.0.1'),
          'port' => env('DB_MYSQL_PORT', '3306')
        ]
      ]
    ],
  ],
  'cache' => [
    'redis' => [
    ]
  ]
];
