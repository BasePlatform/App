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

use Doctrine\Common\Cache\ArrayCache;
use Doctrine\Common\Cache\Cache;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;

namespace Base\Factory;

/**
 * Entity Manager Factory that provides an Doctrine ORM Factory that supports load Entities from multiple locations
 *
 * @package Base\Factory
 */
class EntityManagerFactory
{
  /**
   * Create an Entity Manager
   *
   * @param array $config
   * @param Doctrine\Common\Cache\Cache $cache
   *
   * @return EntityManager
   */
   public static function create(array $config, Cache $cache = null): EntityManager
   {
      $isDevMode = isset($config['debug']) ? ((bool) $config['debug']) : false;
      if (!$cache) {
        $cache = new ArrayCache();
      }
      $resourcesConfig = isset($config['resources']) ? $config['resources'] : [];
      $ormConfig = isset($resourcesConfig['orm']) ? $resourcesConfig['orm'] : [];
      $dbConfig = isset($config['db']) ? $config['db'] : [];
      return EntityManager::create($connecitonConfig, Setup::createAnnotationMetadataConfiguration(
          isset($ormConfig['entityPaths']) ? $ormConfig['entityPaths'] : [],
          $isDevMode,
          isset($ormConfig['proxiesDir']) ? $ormConfig['proxiesFir'] : null,
          $cache,
          false
      ));
   }
}