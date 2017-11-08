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
 * User Entity Interface
 *
 * @package Base\AuthService\Entity
 */
interface UserInterface
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
     * Set the value of field zone
     *
     * @param  string $zone
     * @return $this
     */
    public function setZone(string $zone);

    /**
     * Set the value of field email
     *
     * @param  string $email
     * @return $this
     */
    public function setEmail(string $email);

    /**
     * Set the value of field userName
     *
     * @param  string $userName
     * @return $this
     */
    public function setUserName(string $userName);

    /**
     * Set the value of field displayName
     *
     * @param  string $displayName
     * @return $this
     */
    public function setDisplayName(string $displayName);

    /**
     * Set the value of field tagLine
     *
     * @param  string $tagLine
     * @return $this
     */
    public function setTagLine(string $tagLine);

    /**
     * Set the value of field avatar
     *
     * @param  string $avatar
     * @return $this
     */
    public function setAvatar(string $avatar);

    /**
     * Set the value of field status
     *
     * @param  string $status
     * @return $this
     */
    public function setStatus(string $status);

    /**
     * Set the value of field createdAt
     *
     * @param  \DateTime $createdAt
     *
     * @return $this
     */
    public function setCreatedAt(\DateTime $createdAt);

    /**
     * Set the value of field updatedAt
     *
     * @param  \DateTime $updatedAt
     *
     * @return $this
     */
    public function setUpdatedAt(\DateTime $updatedAt);

    /**
     * Return the value of field zone
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
     * Return the value of field zone
     *
     * @return string
     */
    public function getZone(): string;

    /**
     * Return the value of field email
     *
     * @return string
     */
    public function getEmail(): string;

    /**
     * Return the value of field userName
     *
     * @return string
     */
    public function getUserName(): string;

    /**
     * Return the value of field displayName
     *
     * @return string
     */
    public function getDisplayName(): ?string;

    /**
     * Return the value of field tagLine
     *
     * @return string
     */
    public function getTagLine(): ?string;

    /**
     * Return the value of field avatar
     *
     * @return string
     */
    public function getAvatar(): ?string;

    /**
     * Return the value of field status
     *
     * @return string
     */
    public function getStatus(): string;

    /**
     * Return the value of field createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt(): \DateTime;

    /**
     * Return the value of field updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt(): \DateTime;

    /**
     * Get Status Options from Constants
     * If $status is passed, it will return the value of the status constant
     *
     * @param  string $status
     *
     * @return array|string
     */
    public function getStatusOptions(string $status = null);

    /**
     * Get Zone Options from Constants
     * If $zone is passed, it will return the value of the status constant
     *
     * @param  string $zone
     *
     * @return array|string
     */
    public function getZoneOptions(string $zone = null);
}
