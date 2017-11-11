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

use ReflectionClass;

/**
 * Zone Value Object
 *
 * @package Base\AuthService\ValueObject
 */
class Zone implements ZoneInterface
{
    /**
     * Public Site Zone
     */
    const ZONE_SITE = 'site';

    /**
     * Admin Zone
     */
    const ZONE_ADMIN = 'admin';

    /**
     * System Zone
     */
    const ZONE_SYSTEM = 'system';

    /**
     * @var string
     */
    protected $zoneId;

    /**
     * @param string $zoneId
     */
    public function __construct(string $zoneId = null)
    {
        if (!empty($zoneId)) {
            $this->zoneId = $zoneId;
        }
    }

    /**
     * {@inheritdoc}
     */
    public static function createZone(string $zoneId): ZoneInterface
    {
        return new self($zoneId);
    }

    /**
     * {@inheritdoc}
     */
    public static function getZoneOptions(string $zone = null)
    {
        $reflector = new ReflectionClass(get_class($this));
        $constants = $reflector->getConstants();
        $result = [];
        foreach ($constants as $constant => $value) {
            if (!empty($zone) && $constant == $zone) {
                $result = $value;
                break;
            }
            $prefix = "ZONE_";
            if (strpos($constant, $prefix) !==false) {
                $result[] = $value;
            }
        }
        return $result;
    }

    /**
     * {@inheritdoc}
     */
    public function setZoneId(string $zoneId)
    {
        $this->zoneId = $zoneId;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getZoneId(): string
    {
        return $this->zoneId;
    }

    /**
     * {@inheritdoc}
     */
    public function __toString(): string
    {
        return $this->zoneId;
    }
}
