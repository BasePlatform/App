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

use ArrayAccess;
use RuntimeException;

/**
 * Config Aggregator
 *
 * @package Base\Config
 */
class ConfigAggregator implements ArrayAccess, ConfigInterface
{
    /**
     * @var array
     */
    protected $items = [];

    /**
     * @var string
     */
    protected $cacheFilePath;

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
            $this->items = unserialize(file_get_contents($this->cacheFilePath));
            ;
        } else {
            foreach ($providers as $provider) {
                $this->items = array_replace_recursive($this->items, $provider);
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
        return $this->items;
    }

    /**
     * {@inheritdoc}
     */
    public function has(string $key)
    {
        return $this->get($key) !== null;
    }

    /**
     * {@inheritdoc}
     */
    public function get($key, $default = null)
    {
        if (is_array($key)) {
            return $this->getMany($key);
        }
        return $this->getValueFromArray($this->items, $key, $default);
    }

    /**
     * {@inheritdoc}
     */
    public function getMany($keys)
    {
        $config = [];
        foreach ($keys as $key => $default) {
            if (is_numeric($key)) {
                list($key, $default) = [$default, null];
            }
            $config[$key] = $this->getValueFromArray($this->items, $key, $default);
        }
        return $config;
    }

    /**
     * {@inheritdoc}
     */
    public function set($key, $value = null)
    {
        $keys = is_array($key) ? $key : [$key => $value];
        foreach ($keys as $key => $value) {
            $this->setValueToArray($this->items, $key, $value);
        }
    }

    /**
     * Determine if the given configuration option exists.
     *
     * @param  string  $key
     * @return bool
     */
    public function offsetExists($key)
    {
        return $this->has($key);
    }

    /**
     * Get a configuration option.
     *
     * @param  string  $key
     * @return mixed
     */
    public function offsetGet($key)
    {
        return $this->get($key);
    }

    /**
     * Set a configuration option.
     *
     * @param  string  $key
     * @param  mixed  $value
     * @return void
     */
    public function offsetSet($key, $value)
    {
        $this->set($key, $value);
    }

    /**
     * Unset a configuration option.
     *
     * @param  string  $key
     * @return void
     */
    public function offsetUnset($key)
    {
        $this->set($key, null);
    }

    /**
     * Determine if the given key exists in the provided array.
     *
     * @param  \ArrayAccess|array  $array
     * @param  string|int  $key
     * @return bool
     */
    protected function exists($array, $key)
    {
        if ($array instanceof ArrayAccess) {
            return $array->offsetExists($key);
        }
        return array_key_exists($key, $array);
    }

    /**
     * Determine whether the given value is array accessible.
     *
     * @param  mixed  $value
     * @return bool
     */
    protected function accessible($value)
    {
        return is_array($value) || $value instanceof ArrayAccess;
    }

    /**
     * Determine if the given key exists in the provided array.
     *
     * @param  \ArrayAccess|array  $array
     * @param  string|int  $key
     * @return bool
     */
    protected function getValueFromArray($array, $key, $default = null)
    {
        if (! $this->accessible($array)) {
            return value($default);
        }
        if (is_null($key)) {
            return $array;
        }
        if ($this->exists($array, $key)) {
            return $array[$key];
        }
        if (strpos($key, '.') === false) {
            return $array[$key] ?? value($default);
        }
        foreach (explode('.', $key) as $segment) {
            if ($this->accessible($array) && $this->exists($array, $segment)) {
                $array = $array[$segment];
            } else {
                return value($default);
            }
        }
        return $array;
    }

    /**
     * Set an array item to a given value using "dot" notation.
     *
     * If no key is given to the method, the entire array will be replaced.
     *
     * @param  array   $array
     * @param  string  $key
     * @param  mixed   $value
     * @return array
     */
    protected function setValueToArray(&$array, $key, $value)
    {
        if (is_null($key)) {
            return $array = $value;
        }
        $keys = explode('.', $key);
        while (count($keys) > 1) {
            $key = array_shift($keys);
            // If the key doesn't exist at this depth, we will just create an empty array
            // to hold the next value, allowing us to create the arrays to hold final
            // values at the correct depth. Then we'll keep digging into the array.
            if (! isset($array[$key]) || ! is_array($array[$key])) {
                $array[$key] = [];
            }
            $array = &$array[$key];
        }
        $array[array_shift($keys)] = $value;
        return $array;
    }

    /**
     * Save config to a file Cache
     *
     * @return void
     */
    protected function saveCache(): void
    {
        if (file_exists($this->cacheFilePath) && !is_writable($this->cacheFilePath)) {
            throw new RuntimeException(
                "Could Not Write In Path `{$cacheFilePath}`"
            );
        } else {
            file_put_contents($this->cacheFilePath, serialize($this->items));
        }
    }
}
