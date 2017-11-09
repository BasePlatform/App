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
     * Create a Zone
     *
     * @param string $zoneId
     *
     * @return self
     */
    public static function createZone(string $zoneId): ZoneInterface;

    /**
     * Get Zone Options
     *
     * @param string|null $zoneId
     *
     * @return mixed
     */
    public static function getZoneOptions(string $zoneId = null);

    /**
     * Set the value of zoneId
     *
     * @param  string $id
     *
     * @return $this
     */
    public function setZoneId(string $zoneId);

    /**
     * Return the value of zoneId
     *
     * @return string
     */
    public function getZoneId(): string;

    /**
     * @return string
     */
    public function __toString(): string;
}
