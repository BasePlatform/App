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

/**
 * Create a Config object that merges the data from multiple providers
 * If debug is false, it will create a cache file at
 * /runtime/cache/config.php
 */
return new \Base\Config\ConfigAggregator([
  \Base\TenantService\Service::getConfig(),
  // Add other config that you want to override the config of above services here
  require __DIR__.'/params.php',
  require __DIR__.'/params-local.php',
], __DIR__.'/../runtime/cache/config.php', env('APP_DEBUG', false));
