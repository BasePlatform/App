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
 * User Identity Entity
 *
 * @package Base\AuthService\Entity
 */
class UserIdentity implements UserIdentityInterface, \JsonSerializable
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
    protected $authToken;

    /**
     * @var \DateTime
     */
    protected $recentPasswordUpdateAt;

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
    public function setAuthProviderUid(string $authProviderUid = null)
    {
        $this->authProviderUid = $authProviderUid;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setAuthToken(string $authToken)
    {
        $this->authToken = $authToken;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setPasswordHash(string $passwordHash = null)
    {
        $this->passwordHash = $passwordHash;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setAuthParams(array $authParams = null)
    {
        $this->authParams = $authParams;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setRecentPasswordUpdateAt(\DateTime $recentPasswordUpdateAt = null)
    {
        $this->recentPasswordUpdateAt = $recentPasswordUpdateAt;
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
    public function getAuthToken(): string
    {
        return $this->authToken;
    }

    /**
     * {@inheritdoc}
     */
    public function getPasswordHash(): ?string
    {
        return $this->passwordHash;
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
    public function getRecentPasswordUpdateAt(): ?\DateTime
    {
        return $this->recentPasswordUpdateAt;
    }

    /**
     * {@inheritdoc}
     */
    public function getUpdatedAt(): \DateTime
    {
        return $this->updatedAt;
    }

    /**
     * {@inheritdoc}
     */
    public function toArray(array $excludedAttributes = []): array
    {
        return array_diff_key([
            'id' => $this->id,
            'tenantId' => $this->tenantId,
            'userId' => $this->userId,
            'authProvider' => $this->authProvider,
            'authProviderUid' => $this->authProviderUid,
            // We skip authToken, authParams and passwordHash
            'recentPasswordUpdateAt' => DateTimeHelper::toISO8601($this->recentPasswordUpdateAt),
            'updatedAt' => DateTimeHelper::toISO8601($this->updatedAt)
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
