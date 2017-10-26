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
   * {@inheritdoc}
   */
  public function setId(string $id)
  {
    $this->id = $id;
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function setDomain(string $domain)
  {
    $this->domain = $domain;
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function setPlatform(string $platform)
  {
    $this->platfrom = $platfrom;
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function setStatus(string $status)
  {
    $this->status = $status;

    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function setCreatedAt(int $createdAt)
  {
    $this->createdAt = $createdAt;
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function setUpdatedAt(int $updatedAt)
  {
    $this->updatedAt = $updatedAt;
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getId(): string
  {
    return $this->id;
  }

  /**
   * {@inheritdoc}
   */
  public function getDomain(): string
  {
    return $this->domain;
  }

  /**
   * {@inheritdoc}
   */
  public function getPlatform(): string
  {
    return $this->platform;
  }

  /**
   * {@inheritdoc}
   */
  public function getStatus(): string
  {
    return $this->status;
  }

  /**
   * {@inheritdoc}
   */
  public function getCreatedAt(): int
  {
    return $this->createdAt;
  }

  /**
   * {@inheritdoc}
   */
  public function getUpdatedAt(): int
  {
    return $this->updatedAt;
  }
}
