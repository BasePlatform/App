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

namespace Base\Util;

use RuntimeException;

/**
 * Config
 *
 * @package Base\Util
 */
class Config
{
  /**
   * @var array
   */
  private $config = [];

  /**
   * Aggregate the config from multiple arrays source
   *
   * @param  array        $providers
   * @param  string       $cacheFilePath
   * @param  bool|boolean $isDevMode
   */
  public  function __construct(array $providers, string $cacheFilePath, bool $isDevMode = true) {
    $config = [];
    // Check if file exits
    if (file_exists($cacheFilePath) && !$isDevMode) {
      $config = unserialize(file_get_contents($cacheFilePath));;
    } else {
      foreach ($providers as $provider) {
        $config = array_merge($config, $provider);
      }
      if (!$isDevMode) {
        if (file_exists($cacheFilePath) && !is_writable($cacheFilePath)) {
          throw new RuntimeException(
            "Cannot write in path '{$cacheFilePath}'"
          );
        } else {
          file_put_contents($cacheFilePath, serialize($config));
        }
      }
    }
    $this->config = $config;
  }

  /**
   * Return the full content of the config
   *
   * @return array
   */
  public function getAll()
  {
    return $this->config;
  }

  /**
   * Return the full content of the config
   *
   * @param string $key
   *
   * @return mixed
   */
  public function get(string $key)
  {
    if ($key && array_key_exists($key, $this->config)) {
      return $this->config[$key];
    }
    return false;
  }
}