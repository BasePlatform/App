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

namespace Base\Config;

use RuntimeException;

/**
 * Config Aggregator
 *
 * @package Base\Config
 */
class ConfigAggregator implements ConfigInterface
{
  /**
   * @var array
   */
    private $config = [];

  /**
   * @var string
   */
    private $cacheFilePath;

  /**
   * Aggregate the config from multiple arrays source
   *
   * @param  array        $providers
   * @param  string       $cacheFilePath
   * @param  bool|boolean $enableCache
   */
    public function __construct(array $providers, string $cacheFilePath, bool $enableCache = true)
    {
        $this->cacheFilePath = $cacheFilePath;
      // Check if file exits
        if (!$enableCache && file_exists($this->cacheFilePath)) {
            $this->config = unserialize(file_get_contents($this->cacheFilePath));
            ;
        } else {
            foreach ($providers as $provider) {
                $this->config = array_merge($this->config, $provider);
            }
            if (!$enableCache) {
                $this->saveCache();
            }
        }
    }

  /**
   * {@inheritdoc}
   */
    public function getAll()
    {
        return $this->config;
    }

  /**
   * {@inheritdoc}
   */
    public function get(string $key)
    {
        if ($key && array_key_exists($key, $this->config)) {
            return $this->config[$key];
        }
        return false;
    }

  /**
   * {@inheritdoc}
   */
    public function set(string $key, $value)
    {
        $this->config[$key] = $value;
        return $this;
    }

  /**
   * Save config to a file Cache
   *
   * @return void
   */
    public function saveCache()
    {
        if (file_exists($this->cacheFilePath) && !is_writable($this->cacheFilePath)) {
            throw new RuntimeException(
                "Cannot write in path '{$cacheFilePath}'"
            );
        } else {
            file_put_contents($this->cacheFilePath, serialize($this->config));
        }
    }
}
