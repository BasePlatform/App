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

namespace Base\AuthService\Entity;

/**
 * Policy Entity
 *
 * @package Base\AuthService\Entity
 */
class Policy implements PolicyInterface
{
    /**
     * Public Zone
     */
    const ZONE_PUBLIC = 'public';

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
     * @var string
     */
    protected $type;

    /**
     * @var string
     */
    protected $zone = 'admin';

    /**
     * @var string
     */
    protected $appId = 'default';

    /**
     * @var string
     */
    protected $description;

    /**
     * @var array
     */
    protected $params;

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
    public function setType(string $type)
    {
        $this->type = $type;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setZone(string $zone)
    {
        $this->zone = $zone;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setAppId(string $appId)
    {
        $this->appId = $appId;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setDescription(string $description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setParams(array $params)
    {
        $this->params = $params;
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
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * {@inheritdoc}
     */
    public function getZone(): string
    {
        return $this->zone;
    }

    /**
     * {@inheritdoc}
     */
    public function getAppId(): string
    {
        return $this->appId;
    }

    /**
     * {@inheritdoc}
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * {@inheritdoc}
     */
    public function getParams(): ?array
    {
        return $this->params;
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
}
