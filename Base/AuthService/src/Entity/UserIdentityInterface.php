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

use Base\AuthService\ValueObject\PasswordInterface;

/**
 * User Identity Entity Interface
 *
 * @package Base\AuthService\Entity
 */
interface UserIdentityInterface
{
    /**
     * Set the value of field id
     *
     * @param  int $id
     * @return $this
     */
    public function setId(int $id);

    /**
     * Set the value of field tenantId
     *
     * @param  string $tenantId
     * @return $this
     */
    public function setTenantId(string $tenantId);

    /**
     * Set the value of field userId
     *
     * @param  int $userId
     * @return $this
     */
    public function setUserId(int $userId);

    /**
     * Set the value of field authProvider
     *
     * @param  string $authProvider
     * @return $this
     */
    public function setAuthProvider(string $authProvider);

    /**
     * Set the value of field authProviderUid
     *
     * @param  string $authProviderUid
     * @return $this
     */
    public function setAuthProviderUid(string $authProviderUid);

    /**
     * Set the value of field passwordHash
     *
     * @param  PasswordInterface $passwordHash
     * @return $this
     */
    public function setPasswordHash(PasswordInterface $passwordHash);

    /**
     * Set the value of field authParams
     *
     * @param  string $authParams
     * @return $this
     */
    public function setAuthParams(array $authParams);

    /**
     * Set the value of field accountActivateToken
     *
     * @param  string $accountActivateToken
     * @return $this
     */
    public function setAccountActivateToken(string $accountActivateToken);

    /**
     * Set the value of field accountActivateExpiresAt
     *
     * @param  \DateTime $accountActivateExpiresAt
     * @return $this
     */
    public function setAccountActivateExpiresAt(\DateTime $accountActivateExpiresAt);

    /**
     * Set the value of field passwordResetToken
     *
     * @param  string $passwordResetToken
     * @return $this
     */
    public function setPasswordResetToken(string $passwordResetToken);

    /**
     * Set the value of field passwordResetExpiresAt
     *
     * @param  \DateTime $passwordResetExpiresAt
     * @return $this
     */
    public function setPasswordResetExpiresAt(\DateTime $passwordResetExpiresAt);

    /**
     * Set the value of field recentPasswordUpdateAt
     *
     * @param  \DateTime $recentPasswordUpdateAt
     * @return $this
     */
    public function setRecentPasswordUpdateAt(\DateTime $recentPasswordUpdateAt);

    /**
     * Set the value of field recentLoginAt
     *
     * @param  \DateTime $recentLoginAt
     *
     * @return $this
     */
    public function setRecentLoginAt(\DateTime $recentLoginAt);

    /**
     * Set the value of field updatedAt
     *
     * @param  \DateTime $updatedAt
     *
     * @return $this
     */
    public function setUpdatedAt(\DateTime $updatedAt);

    /**
     * Return the value of field int
     *
     * @return int
     */
    public function getId(): int;

    /**
     * Return the value of field tenantId
     *
     * @return string
     */
    public function getTenantId(): string;

    /**
     * Return the value of field userId
     *
     * @return int
     */
    public function getUserId(): int;

    /**
     * Return the value of field authProvider
     *
     * @return string
     */
    public function getAuthProvider(): string;

    /**
     * Return the value of field authProviderUid
     *
     * @return string|null
     */
    public function getAuthProviderUid(): ?string;

    /**
     * Return the value of field passwordHash
     *
     * @return PasswordInterface|null
     */
    public function getPasswordHash(): ?PasswordInterface;

    /**
     * Return the value of field authParams
     *
     * @return array|null
     */
    public function getAuthParams(): ?array;

    /**
     * Return the value of field accountActivateToken
     *
     * @return string|null
     */
    public function getAccountActivateToken(): ?string;

    /**
     * Return the value of field accountActivateExpiresAt
     *
     * @return \DateTime|null
     */
    public function getAccountActivateExpiresAt(): ?\DateTime;

    /**
     * Return the value of field passwordResetToken
     *
     * @return \DateTime|null
     */
    public function getPasswordResetToken(): ?string;

    /**
     * Return the value of field passwordResetExpiresAt
     *
     * @return \DateTime|null
     */
    public function getPasswordResetExpiresAt(): ?\DateTime;

    /**
     * Return the value of field recentPasswordUpdateAt
     *
     * @return \DateTime
     */
    public function getRecentPasswordUpdateAt(): \DateTime;

    /**
     * Return the value of field recentLoginAt
     *
     * @return \DateTime|null
     */
    public function recentLoginAt(): ?\DateTime;

    /**
     * Return the value of field updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt(): \DateTime;
}
