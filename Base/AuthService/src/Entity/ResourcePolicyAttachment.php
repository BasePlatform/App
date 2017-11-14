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

use Base\Helper\DateTimeHelper;

/**
 * Resource Policy Attachment Entity
 *
 * @package Base\AuthService\Entity
 */
class ResourcePolicyAttachment implements ResourcePolicyAttachmentInterface, \JsonSerializable
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $tenantId;

    /**
     * @var string
     */
    protected $resourceId;

    /**
     * @var string
     */
    protected $policyId;

    /**
     * @var \DateTime
     */
    protected $attachedAt;

    /**
     * {@inheritdoc}
     */
    public function setId(int $id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setTenantId(string $tenantId)
    {
        $this->tenantId = $tenantId;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setResourceId(string $resourceId)
    {
        $this->resourceId = $resourceId;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setPolicyId(string $policyId)
    {
        $this->policyId = $policyId;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setAttachedAt(\DateTime $attachedAt)
    {
        $this->attachedAt = $attachedAt;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getTenantId(): string
    {
        return $this->tenantId;
    }

    /**
     * {@inheritdoc}
     */
    public function getResourceId(): string
    {
        return $this->resourceId;
    }

    /**
     * {@inheritdoc}
     */
    public function getPolicyId(): string
    {
        return $this->policyId;
    }

    /**
     * {@inheritdoc}
     */
    public function getAttachedAt(): \DateTime
    {
        return $this->attachedAt;
    }

    /**
     * {@inheritdoc}
     */
    public static function createResourceId(string $type, string $id): string
    {
        return $type.':'.$id;
    }

    /**
     * {@inheritdoc}
     */
    public function toArray(array $excludedAttributes = []): array
    {
        return array_diff_key([
            'id' => $this->id,
            'tenantId' => $this->tenantId,
            'resourceId' => $this->resourceId,
            'policyId' => $this->policyId,
            'attachedAt' => DateTimeHelper::toISO8601($this->attachedAt)
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
