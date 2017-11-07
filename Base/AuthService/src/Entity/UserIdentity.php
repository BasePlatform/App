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
     * Active Status
     */
    const STATUS_ACTIVE = 'active';

    /**
     * Disabled Status
     */
    const STATUS_DISABLED = 'disabled';

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
    protected $zone = 'default';

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
    protected $accountActivateToken = null;

    /**
     * @var string
     */
    protected $accountActivateStatus = null;

    /**
     * @var \DateTime
     */
    protected $accountActivateExpiresAt = null;

    /**
     * @var string
     */
    protected $passwordResetToken = null;

    /**
     * @var string
     */
    protected $passwordResetStatus = null;

    /**
     * @var \DateTime
     */
    protected $passwordResetExpiresAt = null;

    /**
     * @var \DateTime
     */
    protected $recentPasswordChangeAt;

    /**
     * @var string
     */
    protected $status;

    /**
     * @var bool|null
     */
    protected $_deleted = null;

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
    public function setZone(string $zone)
    {
        $this->zone = $zone;
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
    public function setAccountActivateStatus(string $accountActivateStatus)
    {
        $this->accountActivateStatus = $accountActivateStatus;
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
    public function setPasswordResetStatus(string $passwordResetStatus)
    {
        $this->passwordResetStatus = $passwordResetStatus;
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
    public function setRecentPasswordChangeAt(\DateTime $recentPasswordChangeAt)
    {
        $this->recentPasswordChangeAt = $recentPasswordChangeAt;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setStatus(string $status)
    {
        $this->status = $status;
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
    public function getZone(): string
    {
        return $this->zone;
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
    public function getAuthProviderUid(): string
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
    public function getAccountActivateStatus(): ?string
    {
        return $this->accountActivateStatus;
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
    public function getPasswordResetStatus(): ?string
    {
        return $this->passwordResetStatus;
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
    public function getRecentPasswordChangeAt(): ?\DateTime
    {
        return $this->recentPasswordChangeAt;
    }

    /**
     * {@inheritdoc}
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * {@inheritdoc}
     */
    public function getStatusOptions(string $status = null)
    {
        $reflector = new ReflectionClass(get_class($this));
        $constants = $reflector->getConstants();
        $result = [];
        foreach ($constants as $constant => $value) {
            if (!empty($status) && $constant == $status) {
                $result = $value;
                break;
            }
            $prefix = "STATUS_";
            if (strpos($constant, $prefix) !==false) {
                $result[] = $value;
            }
        }
        return $result;
    }
}
