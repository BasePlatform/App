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
 * Tenant Entity
 *
 * @package Base\TenantService\Entity
 */
class Tenant
{
  /**
   * @var string
   */
  protected $id;

  /**
   * @var string
   */
  protected $domain;

  /**
   * @var string
   */
  protected $platform;

  /**
   * @var string
   */
  protected $status = 'disabled';

  /**
   * @var integer
   */
  protected $createdAt;

  /**
   * @var integer
   */
  protected $updatedAt;

  /**
   * Set the value of field domain
   *
   * @param  string $domain
   *
   * @return $this
   */
  public function setDomain(string $domain)
  {
    $this->domain = $domain;
    return $this;
  }

  /**
   * Set the value of field Platform
   *
   * @param  string $platform
   *
   * @return $this
   */
  public function setPlatform(string $platform)
  {
    $this->platfrom = $platfrom;
    return $this;
  }

  /**
   * Set the value of field status
   *
   * @param  string $status
   *
   * @return $this
   */
  public function setStatus(string $status)
  {
    $this->status = $status;

    return $this;
  }

  /**
   * Set the value of field createdAt
   *
   * @param  integer $createdAt
   *
   * @return $this
   */
  public function setCreatedAt(int $createdAt)
  {
    $this->createdAt = $createdAt;
    return $this;
  }

  /**
   * Set the value of field updatedAt
   *
   * @param  integer $updatedAt
   *
   * @return $this
   */
  public function setUpdatedAt(int $updatedAt)
  {
    $this->updatedAt = $updatedAt;
    return $this;
  }

  /**
   * Return the value of field id
   *
   * @return string
   */
  public function getId(): string
  {
    return $this->id;
  }

  /**
   * Return the value of field tenantId
   *
   * @return string
   */
  public function getTenantId(): string
  {
    return $this->tenantId;
  }

  /**
   * Return the value of field domain
   *
   * @return string
   */
  public function getDomain(): string
  {
    return $this->domain;
  }

  /**
   * Return the value of field platform
   *
   * @return string
   */
  public function getPlatform(): string
  {
    return $this->platform;
  }

  /**
   * Return the value of field status
   *
   * @return string
   */
  public function getStatus(): string
  {
    return $this->status;
  }

  /**
   * Return the value of field createdAt
   *
   * @return integer
   */
  public function getCreatedAt(): int
  {
    return $this->createdAt;
  }

  /**
   * Return the value of field updatedAt
   *
   * @return integer
   */
  public function getUpdatedAt(): int
  {
    return $this->updatedAt;
  }
}
