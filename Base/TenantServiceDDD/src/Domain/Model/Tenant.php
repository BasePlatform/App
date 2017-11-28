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

use Base\Helper\DateTimeHelper;

/**
 * Tenant Entity
 *
 * @package Base\TenantService\Domain\Model
 */
class Tenant implements TenantInterface
{
    use \Base\Event\HasEventsTrait;

    /**
     * @var TenantIdInterface
     */
    protected $id;

    /**
     * @var string
     */
    protected $domain;

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
     * @param TenantIdInterface          $id
     * @param string|null                $domain
     * @param bool|boolean               $isRootMember
     * @param TenantStatusInterface|null $status
     * @param \DateTime|null             $createdAt
     * @param \DateTime|null             $updatedAt
     */
    public function __construct(
        TenantIdInterface $id,
        string $domain = null,
        bool $isRootMember = false,
        TenantStatusInterface $status = null,
        \DateTime $createdAt = null,
        \DateTime $updatedAt = null
    ) {
        $this->id = $id;
        $this->domain = !empty($domain) ? $domain : (string) $this->id;
        $this->isRootMember = $isRootMember;
        $this->status = $status ?: TenantStatus::createStatusDisabled();
        $now = DateTimeHelper::now();
        $this->createdAt = $createdAt ?: $now;
        $this->updatedAt = $updatedAt ?: $now;
    }

    /**
     * {@inheritdoc}
     */
    public function register()
    {
        $this->status = TenantStatus::createStatusActive();
        $this->updatedAt = DateTimeHelper::now();
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function activate()
    {
        $this->status = TenantStatus::createStatusActive();
        $this->updatedAt = DateTimeHelper::now();
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function disable()
    {
        $this->status = TenantStatus::createStatusDisabled();
        $this->updatedAt = DateTimeHelper::now();
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
