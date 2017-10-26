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
 * TenantId Object
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
   * Create a TenantId from a tenantId and domain
   *
   * If no tenantId is provided, it will generate a uuid4() with domain
   *
   * @param string $tenantId
   * @param string $domain
   *
   * @return TenantId
   */
  public static function create(string $tenantId = '', string $domain = ''): TenantId
  {
    if ($tenantId != '') {
      return new self($tenantId.$domain);
    } else {
      $uuid = Uuid::uuid4()->toString();
      return new self($uuid.$domain);
    }
  }

  /**
   * Return the value of id
   *
   * @return integer
   */
  public function getId(): string
  {
    return $this->id;
  }
}
