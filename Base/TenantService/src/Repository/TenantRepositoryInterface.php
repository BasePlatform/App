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

namespace Base\TenantService\Repository;

use Base\TenantService\ValueObject\TenantIdInterface;
use Base\TenantService\Entity\TenantInterface;

/**
 * Tenant Repository Interface
 *
 * @package Base\TenantService\Repository
 */
interface TenantRepositoryInterface
{
  /**
   * Get Tenant by TenantId
   *
   * @param TenantIdInterface $tenantId
   *
   * @return TenantInterface|null
   */
    public function get(TenantIdInterface $tenantId): ?TenantInterface;

  /**
   * Add a Tenant
   *
   * @param TenantInterface $tenant
   *
   * @return TenantIdInterface
   */
    public function add(TenantInterface $tenant): ?TenantIdInterface;

  /**
   * Convert an array data from fetch assoc to Entity
   *
   * @param array|boolean $data
   *
   * @return TenantInterface|null
   */
    public function convertToEntity($data): ?TenantInterface;
}
