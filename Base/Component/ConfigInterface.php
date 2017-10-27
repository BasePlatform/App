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

namespace Base\Component;

use RuntimeException;

/**
 * Config Interface
 *
 * @package Base\Component
 */
interface ConfigInterface
{
  /**
   * Return the full content of the config
   *
   * @return array
   */
  public function getAll();

  /**
   * Return the full content of the config
   *
   * @param string $key
   *
   * @return mixed
   */
  public function get(string $key);
}