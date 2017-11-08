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
 * User Profile Entity
 *
 * @package Base\AuthService\Entity
 */
class UserProfile implements UserProfileInterface
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
     * @var id
     */
    protected $userId;

    /**
     * @var string
     */
    protected $gender;

    /**
     * @var string
     */
    protected $firstName;

    /**
     * @var string
     */
    protected $lastName;

    /**
     * @var string
     */
    protected $location;

    /**
     * @var string
     */
    protected $company;

    /**
     * @var \DateTime
     */
    protected $birthDate;

    /**
     * @var array
     */
    protected $info;

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
    public function setGender(string $gender)
    {
        $this->gender = $gender;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setBirthDate(\DateTime $birthDate)
    {
        $this->birthDate = $birthDate;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setFirstName(string $firstName)
    {
        $this->firstName = $firstName;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setLastName(string $lastName)
    {
        $this->lastName = $lastName;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setLocation(string $location)
    {
        $this->location = $location;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setCompany(string $company)
    {
        $this->company = $company;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setInfo(array $info)
    {
        $this->info = $info;
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
    public function getGender(): ?string
    {
        return $this->gender;
    }

    /**
     * {@inheritdoc}
     */
    public function getBirthDate(): \DateTime
    {
        return $this->birthDate;
    }

    /**
     * {@inheritdoc}
     */
    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    /**
     * {@inheritdoc}
     */
    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    /**
     * {@inheritdoc}
     */
    public function getLocation(): ?string
    {
        return $this->location;
    }

    /**
     * {@inheritdoc}
     */
    public function getCompany(): ?string
    {
        return $this->company;
    }

    /**
     * {@inheritdoc}
     */
    public function getInfo(): ?array
    {
        return $this->info;
    }

    /**
     * {@inheritdoc}
     */
    public function getUpdatedAt(): \DateTime
    {
        return $this->updatedAt;
    }
}
