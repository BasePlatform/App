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
     * @param  string|null $platform
     *
     * @return $this
     */
    public function setPlatform(string $platform = null);

    /**
     * Set the value of field isRootMember
     *
     * @param  bool $isRootMember
     *
     * @return $this
     */
    public function setIsRootMember(bool $isRootMember);

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
     * Return the value of field id
     *
     * @return TenantIdInterface
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
     * @return string|null
     */
    public function getPlatform(): ?string;

    /**
     * Return the value of field isRootMember
     *
     * @return bool
     */
    public function getIsRootMember(): bool;

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
     * @param  string|null $status
     *
     * @return array|string
     */
    public function getStatusOptions(string $status = null);

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
