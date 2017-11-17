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

use Base\AuthService\ValueObject\ZoneInterface;

/**
 * Policy Entity
 *
 * @package Base\AuthService\Entity
 */
class Policy implements PolicyInterface
{
    /**
     * Permission Type
     */
    const TYPE_PERMISSION = 'permission';

    /**
     * Role Type
     */
    const TYPE_ROLE = 'role';

    /**
     * @var string
     */
    protected $id;

    /**
     * @var string
     */
    protected $appId;

    /**
     * @var string
     */
    protected $type;

    /**
     * @var ZoneInterface
     */
    protected $zone;

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
    public function rules(): array
    {
        return [
            // Id Required
            'idRequired' => ['id', 'required'],
            // Id Length
            'idLength' => ['tenantId', ['stringType','length'], 'min' => 3, 'max' => 255],
            // AppId Required
            'appIdRequired' => ['appId', 'required'],
            // AppId Length
            'appIdLength' => ['id', ['stringType','length'], 'min' => 1, 'max' => 64],
            // Type Required
            'typeRequired' => ['type', 'required'],
            // Type Enum
            'typeEnum' => ['type', 'in', 'haystack'=> [self::TYPE_PERMISSION, self::TYPE_ROLE]],
            // Zone Required
            'zoneRequired' => ['zone', 'required'],
            // Description Length
            'descriptionLength' => ['description', ['stringType','length'], 'min' => null, 'max' => 255]
        ];
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
    public function setAppId(string $appId)
    {
        $this->appId = $appId;
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
    public function setZone(ZoneInterface $zone)
    {
        $this->zone = $zone;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setDescription(string $description = null)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setParams(array $params = null)
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
    public function getAppId(): string
    {
        return $this->appId;
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
    public function getZone(): ZoneInterface
    {
        return $this->zone;
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
    public function toArray(array $excludedAttributes = []): array
    {
        return array_diff_key([
            'id' => $this->id,
            'appId' => $this->appId,
            'type' => $this->type,
            'zone' => $this->zone->toString(),
            'description' => $this->description,
            'params' => $this->params
        ], array_flip($excludedAttributes));
    }

    /**
     * {@inheritdoc}
     */
    public function jsonSerialize()
    {
        return $this->toArray();
    }
}
