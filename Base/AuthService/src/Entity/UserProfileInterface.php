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
 * User Profile Entity Interface
 *
 * @package Base\AuthService\Entity
 */
interface UserProfileInterface
{
    /**
     * Set the value of field id
     *
     * @param  int $id
     *
     * @return $this
     */
    public function setId(int $id);

    /**
     * Set the value of field tenantId
     *
     * @param  string $tenantId
     *
     * @return $this
     */
    public function setTenantId(string $tenantId);

    /**
     * Set the value of field userId
     *
     * @param  int $userId
     *
     * @return $this
     */
    public function setUserId(int $userId);

    /**
     * Set the value of field gender
     *
     * @param  string|null $gender
     *
     * @return $this
     */
    public function setGender(string $gender = null);

    /**
     * Set the value of field birthDate
     *
     * @param  \DateTime|null $birthDate
     *
     * @return $this
     */
    public function setBirthDate(\DateTime $birthDate = null);

    /**
     * Set the value of field firstName
     *
     * @param  string|null $firstName
     *
     * @return $this
     */
    public function setFirstName(string $firstName = null);

    /**
     * Set the value of field lastName
     *
     * @param  string|null $lastName
     *
     * @return $this
     */
    public function setLastName(string $lastName = null);

    /**
     * Set the value of field location
     *
     * @param  string|null $location
     *
     * @return $this
     */
    public function setLocation(string $location = null);

    /**
     * Set the value of field company
     *
     * @param  string|null $company
     *
     * @return $this
     */
    public function setCompany(string $company = null);

    /**
     * Set the value of field info
     *
     * @param  array|null $info
     *
     * @return $this
     */
    public function setInfo(array $info = null);

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
     * @return int
     */
    public function getId(): int;

    /**
     * Return the value of field tenantId
     *
     * @return int
     */
    public function getTenantId(): string;

    /**
     * Return the value of field userId
     *
     * @return int
     */
    public function getUserId(): int;

    /**
     * Return the value of field gender
     *
     * @return string|null
     */
    public function getGender(): ?string;

    /**
     * Return the value of field birthDate
     *
     * @return \DateTime|null
     */
    public function getBirthDate(): ?\DateTime;

    /**
     * Return the value of field firstName
     *
     * @return string|null
     */
    public function getFirstName(): ?string;

    /**
     * Return the value of field lastName
     *
     * @return string|null
     */
    public function getLastName(): ?string;

    /**
     * Return the value of field location
     *
     * @return string|null
     */
    public function getLocation(): ?string;

    /**
     * Return the value of field company
     *
     * @return string|null
     */
    public function getCompany(): ?string;

    /**
     * Return the value of field info
     *
     * @return array|null
     */
    public function getInfo(): ?array;

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
