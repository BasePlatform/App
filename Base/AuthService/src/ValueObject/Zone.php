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
    protected $id;

    /**
     * @param string $id
     */
    public function __construct(string $id = null)
    {
        if (!empty($id)) {
            $this->id = $id;
        }
    }

    /**
     * {@inheritdoc}
     */
    public static function createFromString(string $id = null): ZoneInterface
    {
        return new self($id);
    }

    /**
     * {@inheritdoc}
     */
    public function getZoneOptions(string $zone = null)
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
    public function setId(string $id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function toString(): string
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function __toString(): string
    {
        return $this->toString();
    }

    /**
     * {@inheritdoc}
     */
    public function sameValueAs(self $other): bool
    {
        return $this->toString() === $other->toString();
    }
}
