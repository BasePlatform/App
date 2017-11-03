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

namespace Base\TenantService\ValueObject;

/**
 * TenantId ValueObject Interface
 *
 * @package Base\TenantService\ValueObject
 */
interface TenantIdInterface
{
  /**
   * Create a Tenant Id
   *
   * Generate a unique id if name is blank
   *
   * @param string $name
   * @param string $domain
   *
   * @return self
   */
    public static function create(string $name, string $domain): TenantIdInterface;

  /**
   * Set the value of field id
   *
   * @param  string $id
   *
   * @return $this
   */
    public function setId(string $id);

  /**
   * Return the value of id
   *
   * @return string
   */
    public function getId(): string;

  /**
   * @return string
   */
    public function __toString(): string;
}
