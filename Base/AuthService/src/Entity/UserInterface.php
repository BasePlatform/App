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
     * Set the value of field username
     *
     * @param  string $username
     * @return $this
     */
    public function setUsername(string $username);

    /**
     * Set the value of field email
     *
     * @param  string $email
     * @return $this
     */
    public function setEmail(string $email);

    /**
     * Set the value of field displayName
     *
     * @param  string $displayName
     * @return $this
     */
    public function setDisplayName(string $displayName);

    /**
     * Set the value of field tagline
     *
     * @param  string $tagline
     * @return $this
     */
    public function setTagline(string $tagline);

    /**
     * Set the value of field avatar
     *
     * @param  string $avatar
     * @return $this
     */
    public function setAvatar(string $avatar);

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
     * Return the value of field username
     *
     * @return string
     */
    public function getUsername(): string;

    /**
     * Return the value of field email
     *
     * @return string
     */
    public function getEmail(): string;

    /**
     * Return the value of field displayName
     *
     * @return string
     */
    public function getDisplayName(): ?string;

    /**
     * Return the value of field tagline
     *
     * @return string
     */
    public function getTagline(): ?string;

    /**
     * Return the value of field avatar
     *
     * @return string
     */
    public function getAvatar(): ?string;
}
