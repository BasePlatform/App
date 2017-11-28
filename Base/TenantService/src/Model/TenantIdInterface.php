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

namespace Base\TenantService\Model;

use Base\Model\ValueObject\ValueObjectInterface;

/**
 * Tenant Id Value Object Interface
 *
 * @package Base\TenantService\Model
 */
interface TenantIdInterface extends ValueObjectInterface
{
    /**
     * Create a Tenant Id from String Name and Domain
     *
     * @param string $name
     *
     * @return self
     */
    public static function createFromString(string $value): TenantIdInterface;

    /**
     * Create a Tenant Id from String Name and Domain
     *
     * Generate a unique id if name is blank
     *
     * @param string $name
     * @param string $domain
     *
     * @return self
     */
    public static function createFromStringNameDomain(string $name = '', string $domain = ''): TenantIdInterface;

    /**
     * Validate a string value for the value object
     *
     * @param  string $value
     *
     * @return boolean
     */
    public function validate(string $value);

    /**
     * @return string
     */
    public function toString(): string;

    /**
     * @return string
     */
    public function __toString(): string;
}
