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

use Base\TenantService\ValueObject\TenantIdInterface;

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
     * @param  TenantIdInterface $id
     *
     * @return $this
     */
    public function setId(TenantIdInterface $id);

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
    public function setCreatedAt(int $createdAt);

    /**
     * Set the value of field updatedAt
     *
     * @param  integer $updatedAt
     *
     * @return $this
     */
    public function setUpdatedAt(int $updatedAt);

    /**
     * Return the value of field id
     *
     * @return TenantInterface
     */
    public function getId(): TenantIdInterface;

    /**
     * Return the value of field domain
     *
     * @return string
     */
    public function getDomain(): string;

    /**
     * Return the value of field platform
     *
     * @return string
     */
    public function getPlatform(): ?string;

    /**
     * Return the value of field status
     *
     * @return string
     */
    public function getStatus(): string;

    /**
     * Return the value of field createdAt
     *
     * @return integer
     */
    public function getCreatedAt(): int;

    /**
     * Return the value of field updatedAt
     *
     * @return integer
     */
    public function getUpdatedAt(): int;

    /**
     * Get Status Options from Constants
     * If $status is passed, it will return the value of the status constant
     *
     * @param  string $domain
     *
     * @return array|string
     */
    public function getStatusOptions(string $status = null);
}
