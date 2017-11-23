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

namespace Base\TenantService\Domain\Model;

/**
 * Tenant Entity
 *
 * @package Base\TenantService\Domain\Model
 */
class Tenant implements TenantInterface
{
    /**
     * @var TenantIdInterface
     */
    protected $id;

    /**
     * @var string
     */
    protected $domain;

    /**
     * @var string
     */
    protected $platform;

    /**
     * @var boolean
     */
    protected $isRootMember = false;

    /**
     * @var TenantStatusInterface
     */
    protected $status;

    /**
     * @var \DateTime
     */
    protected $createdAt;

    /**
     * @var \DateTime
     */
    protected $updatedAt;

    /**
     * {@inheritdoc}
     */
    public function setId(TenantIdInterface $id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setDomain(string $domain)
    {
        $this->domain = $domain;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setPlatform(string $platform = null)
    {
        $this->platform = $platform;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setIsRootMember(bool $isRootMember)
    {
        $this->isRootMember = $isRootMember;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setStatus(TenantStatusInterface $status)
    {
        $this->status = $status;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setCreatedAt(\DateTime $createdAt)
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setUpdatedAt(\DateTime $updatedAt)
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getId(): TenantIdInterface
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getDomain(): string
    {
        return $this->domain;
    }

    /**
     * {@inheritdoc}
     */
    public function getPlatform(): ?string
    {
        return $this->platform;
    }

    /**
     * {@inheritdoc}
     */
    public function getIsRootMember(): bool
    {
        return $this->isRootMember;
    }

    /**
     * {@inheritdoc}
     */
    public function getStatus(): TenantStatusInterface
    {
        return $this->status;
    }

    /**
     * {@inheritdoc}
     */
    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    /**
     * {@inheritdoc}
     */
    public function getUpdatedAt(): \DateTime
    {
        return $this->updatedAt;
    }
}
