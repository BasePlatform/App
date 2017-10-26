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
   * @return \Doctrine\ORM\EntityManager
   */
   public static function create(array $config, \Doctrine\Common\Cache\Cache $cache = null): \Doctrine\ORM\EntityManager
   {

      $isDevMode = isset($config['debug']) ? ((bool) $config['debug']) : false;
      if (!$cache) {
        $cache = new \Doctrine\Common\Cache\ArrayCache();
      }
      $resourcesConfig = isset($config['resources']) ? $config['resources'] : [];
      $ormConfig = isset($resourcesConfig['orm']) ? $resourcesConfig['orm'] : [];
      $connConfig = (isset($config['db']) && isset($config['db']['mysql'])) ? $config['db']['mysql'] : [];

      return \Doctrine\ORM\EntityManager::create($connConfig, \Doctrine\ORM\Tools\Setup::createAnnotationMetadataConfiguration(
          isset($ormConfig['entityPaths']) ? $ormConfig['entityPaths'] : [],
          $isDevMode,
          isset($ormConfig['proxiesDir']) ? $ormConfig['proxiesFir'] : null,
          $cache,
          false
      ));
   }
}