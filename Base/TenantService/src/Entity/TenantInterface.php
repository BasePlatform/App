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

namespace Base\TenantService\Entity;

/**
 * Tenant Entity Interface
 *
 * @package Base\TenantService\Entity
 */
interface TenantInterface
{
    /**
     * Set the value of field id
     *
     * @param  string $id
     *
     * @return $this
     */
    public function setId(string $id);

    /**
     * Set the value of field domain
     *
     * @param  string $domain
     *
     * @return $this
     */
    public function setDomain(string $domain);

    /**
     * Set the value of field Platform
     *
     * @param  string $platform
     *
     * @return $this
     */
    public function setPlatform(string $platform);

    /**
     * Set the value of field timeZone
     *
     * @param  string $timeZone
     *
     * @return $this
     */
    public function setTimeZone(string $timeZone);

    /**
     * Set the value of field status
     *
     * @param  string $status
     *
     * @return $this
     */
    public function setStatus(string $status);

    /**
     * Set the value of field createdAt
     *
     * @param  integer $createdAt
     *
     * @return $this
     */
    public function setCreatedAt(\DateTime $createdAt);

    /**
     * Set the value of field updatedAt
     *
     * @param  integer $updatedAt
     *
     * @return $this
     */
    public function setUpdatedAt(\DateTime $updatedAt);

    /**
     * Return the value of field id
     *
     * @return string
     */
    public function getId(): string;

    /**
     * Return the value of field domain
     *
     * @return string
     */
    public function getDomain(): string;

    /**
     * Return the value of field platform
     *
     * @return string|null
     */
    public function getPlatform(): string;

    /**
     * Return the value of field timeZone
     *
     * @return string
     */
    public function getTimeZone(): string;

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
     * Create a Tenant Id
     *
     * Generate a unique id if name is blank
     *
     * @param string $name
     * @param string $domain
     *
     * @return string
     */
    public static function createTenantId(string $name = '', string $domain = ''): string;
}
