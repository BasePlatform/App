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
     * @param  string|null $authProviderUid
     * @return $this
     */
    public function setAuthProviderUid(string $authProviderUid = null);

    /**
     * Set the value of field authToken
     *
     * @param  string $authToken
     * @return $this
     */
    public function setAuthToken(string $authToken);

    /**
     * Set the value of field passwordHash
     *
     * @param  string|null $passwordHash
     * @return $this
     */
    public function setPasswordHash(string $passwordHash = null);

    /**
     * Set the value of field authParams
     *
     * @param  array|null $authParams
     * @return $this
     */
    public function setAuthParams(array $authParams = null);

    /**
     * Set the value of field recentPasswordUpdateAt
     *
     * @param  \DateTime|null $recentPasswordUpdateAt
     * @return $this
     */
    public function setRecentPasswordUpdateAt(\DateTime $recentPasswordUpdateAt = null);

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
     * Return the value of field authToken
     *
     * @return string
     */
    public function getAuthToken(): string;

    /**
     * Return the value of field passwordHash
     *
     * @return string|null
     */
    public function getPasswordHash(): ?string;

    /**
     * Return the value of field authParams
     *
     * @return array|null
     */
    public function getAuthParams(): ?array;

    /**
     * Return the value of field recentPasswordUpdateAt
     *
     * @return \DateTime|null
     */
    public function getRecentPasswordUpdateAt(): ?\DateTime;

    /**
     * Return the value of field updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt(): \DateTime;

    /**
     * Convert Entity to Array
     *
     * @param array excludedAttributes
     *
     * @return array
     */
    public function toArray(array $excludedAttributes = []): array;

    /**
     * Specify data which should be serialized to JSON
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    public function jsonSerialize();
}
