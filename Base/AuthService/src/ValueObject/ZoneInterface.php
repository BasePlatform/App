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

namespace Base\AuthService\ValueObject;

/**
 * Zone Value Object Interface
 *
 * @package Base\AuthService\ValueObject
 */
interface ZoneInterface
{
    /**
     * Create a Zone from string
     *
     * @param string|null $id
     *
     * @return self
     */
    public static function createFromString(string $id = null): ZoneInterface;

    /**
     * Get Zone Options
     *
     * @param string|null $zone
     *
     * @return mixed
     */
    public function getZoneOptions(string $zone = null);

    /**
     * Set the value of id
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
    public function toString(): string;

    /**
     * @return string
     */
    public function __toString(): string;

    /**
     * Equal comparision
     *
     * @param ZoneInterface $other
     *
     * @return bool
     */
    public function equals(self $other): ZoneInterface;
}
