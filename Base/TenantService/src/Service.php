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

namespace Base\TenantService;

/**
 * Tenant Service
 *
 * @package Base\TenantService
 */
class Service
{
  /**
   * @var int Error Code Space
   */
  const ERROR_CODE_SPACE = 1000;

  /**
   * Get Service Config
   *
   * @return array Config array
   */
  public static function getConfig()
  {
    return array_merge(
      require __DIR__.'/../config/dependencies.php',
      require __DIR__.'/../config/resources.php',
      require __DIR__.'/../config/routes.php',
      require __DIR__.'/../config/roles.php'
    );
  }
}