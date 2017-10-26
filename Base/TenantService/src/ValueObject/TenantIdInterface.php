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

/**
 * TenantId Interface
 *
 * @package Base\TenantService\ValueObject
 */
interface TenantId
{
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
  public static function create(string $tenantId = '', string $domain = ''): TenantId;

  /**
   * Return the value of id
   *
   * @return integer
   */
  public function getId(): string;
}
