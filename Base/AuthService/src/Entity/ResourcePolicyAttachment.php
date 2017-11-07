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
 * Resource Policy Attachment Entity
 *
 * @package Base\AuthService\Entity
 */
class ResourcePolicyAttachment implements ResourcePolicyAttachmentInterface
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
    protected $zone = 'default';

    /**
     * @var string
     */
    protected $resourceId;

    /**
     * @var string
     */
    protected $policy;

    /**
     * @var array
     */
    protected $policyParams;

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
    public function setZone(string $zone)
    {
        $this->zone = $zone;
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
    public function setPolicy(string $policy)
    {
        $this->policy = $policy;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setPolicyParams(array $policyParams)
    {
        $this->policyParams = $policyParams;
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
    public function getZone(): string
    {
        return $this->zone;
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
    public function getPolicy(): string
    {
        return $this->policy;
    }

    /**
     * {@inheritdoc}
     */
    public function getPolicyParams(): ?array
    {
        return $this->policyParams;
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
}
