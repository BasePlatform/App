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

use Base\TenantService\Entity\TenantInterface;
use Base\Common\ValueObject\TenantIdInterface;

/**
 * Tenant Repository Interface
 *
 * @package Base\TenantService\Repository
 */
interface TenantRepositoryInterface
{
    /**
     * Find Tenant by Tenant Id
     *
     * @param TenantIdInterface $tenantId
     *
     * @return TenantInterface|null
     */
    public function find(TenantIdInterface $tenantId): ?TenantInterface;

    /**
     * Insert a Tenant
     *
     * @param TenantInterface $item
     *
     * @return TenantInterface|null
     */
    public function insert(TenantInterface $item): ?TenantInterface;

    /**
     * Convert an array data from fetch assoc to Entity
     *
     * @param array|boolean $data
     *
     * @return TenantInterface|null
     */
    public function convertToEntity($data): ?TenantInterface;
}
