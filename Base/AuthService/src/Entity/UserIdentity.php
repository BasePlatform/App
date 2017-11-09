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
 * User Identity Entity
 *
 * @package Base\AuthService\Entity
 */
class UserIdentity implements UserIdentityInterface
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
     * @var int
     */
    protected $userId;

    /**
     * @var string
     */
    protected $authProvider = 'app';

    /**
     * @var string
     */
    protected $authProviderUid;

    /**
     * @var string
     */
    protected $passwordHash;

    /**
     * @var array
     */
    protected $authParams;

    /**
     * @var string
     */
    protected $accountActivateToken;

    /**
     * @var \DateTime
     */
    protected $accountActivateExpiresAt;

    /**
     * @var string
     */
    protected $passwordResetToken;

    /**
     * @var \DateTime
     */
    protected $passwordResetExpiresAt;

    /**
     * @var \DateTime
     */
    protected $recentPasswordUpdateAt;

    /**
     * @var \DateTime
     */
    protected $recentLoginAt;

    /**
     * @var \DateTime
     */
    protected $updatedAt;

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
    public function setUserId(int $userId)
    {
        $this->userId = $userId;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setAuthProvider(string $authProvider)
    {
        $this->authProvider = $authProvider;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setAuthProviderUid(string $authProviderUid)
    {
        $this->authProviderUid = $authProviderUid;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setPasswordHash(string $passwordHash)
    {
        $this->passwordHash = $passwordHash;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setAuthParams(array $authParams)
    {
        $this->authParams = $authParams;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setAccountActivateToken(string $accountActivateToken)
    {
        $this->accountActivateToken = $accountActivateToken;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setAccountActivateExpiresAt(\DateTime $accountActivateExpiresAt)
    {
        $this->accountActivateExpiresAt = $accountActivateExpiresAt;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setPasswordResetToken(string $passwordResetToken)
    {
        $this->passwordResetToken = $passwordResetToken;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setPasswordResetExpiresAt(\DateTime $passwordResetExpiresAt)
    {
        $this->passwordResetExpiresAt = $passwordResetExpiresAt;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setRecentPasswordUpdateAt(\DateTime $getRecentPasswordUpdateAt)
    {
        $this->getRecentPasswordUpdateAt = $getRecentPasswordUpdateAt;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setRecentLoginAt(\DateTime $recentLoginAt)
    {
        $this->recentLoginAt = $recentLoginAt;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setUpdatedAt(\DateTime $updatedA)
    {
        $this->updatedAt = $updatedAt;
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
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthProvider(): string
    {
        return $this->authProvider;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthProviderUid(): ?string
    {
        return $this->authProviderUid;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthParams(): ?array
    {
        return $this->authParams;
    }

    /**
     * {@inheritdoc}
     */
    public function getAccountActivateToken(): ?string
    {
        return $this->accountActivateToken;
    }

    /**
     * {@inheritdoc}
     */
    public function getAccountActivateExpiresAt(): ?\DateTime
    {
        return $this->accountActivateExpiresAt;
    }

    /**
     * {@inheritdoc}
     */
    public function getPasswordResetToken(): ?string
    {
        return $this->passwordResetToken;
    }

    /**
     * {@inheritdoc}
     */
    public function getPasswordResetExpiresAt(): ?\DateTime
    {
        return $this->passwordResetExpiresAt;
    }

    /**
     * {@inheritdoc}
     */
    public function getRecentPasswordUpdateAt(): \DateTime
    {
        return $this->recentPasswordUpdateAt;
    }

    /**
     * {@inheritdoc}
     */
    public function getRecentLoginAt(): ?\DateTime
    {
        return $this->recentLoginAt;
    }

    /**
     * {@inheritdoc}
     */
    public function getUpdatedAt(): \DateTime
    {
        return $this->updatedAt;
    }
}
