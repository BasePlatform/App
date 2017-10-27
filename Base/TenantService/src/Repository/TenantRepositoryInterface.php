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

use Base\TenantService\ValueObject\TenantId;
use Base\TenantService\Entity\TenantInterface;

/**
 * Tenant Repository Interface
 *
 * @package Base\TenantService\Service
 */
interface TenantRepositoryInterface
{
  /**
   * Find Tenant by TenantId
   *
   * @param TenantId $tenantId
   *
   * @return TenantInterface
   */
  public function findOneById(TenantId $tenantId);
}