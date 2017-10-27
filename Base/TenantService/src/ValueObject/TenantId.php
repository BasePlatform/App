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

namespace Base\TenantService\ValueObject;

use Ramsey\Uuid\Uuid;

/**
 * TenantId ValueObject
 *
 * @package Base\TenantService\ValueObject
 */
class TenantId
{
  /**
   * @var string
   */
  protected $id;

  /**
   * @param string $id
   */
  public function __construct(string $id)
  {
    $this->id = $id;
  }

  /**
   * Create a Tenant Id
   *
   * Generate a unique id if tenantName is blank
   *
   * @param string $tenantName
   * @param string $domain
   *
   * @return self
   */
  public static function create(string $tenantName = '', string $domain = '')
  {
    if ($tenantName != '') {
      return new self($tenantName.$domain);
    } else {
      $uuid = Uuid::uuid4()->toString();
      return new self($uuid.$domain);
    }
  }

  /**
   * Return the value of id
   *
   * @return string
   */
  public function getId(): string
  {
    return $this->id;
  }

  /**
   * @return string
   */
  public function __toString(): string
  {
    return $this->id;
  }
}
