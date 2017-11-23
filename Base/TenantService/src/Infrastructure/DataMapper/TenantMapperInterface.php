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

namespace Base\TenantService\Infrastructure\DataMapper;

use Base\Db\DataMapper\DataMapperInterface;
use Base\TenantService\Domain\Model\TenantInterface;
use Base\TenantService\Domain\Model\TenantIdInterface;

/**
 * Tenant Mapper Interface
 *
 * @package Base\TenantService\Infrastructure\DataMapper
 */
interface TenantMapperInterface extends DataMapperInterface
{
    /**
     * Find Tenant by Tenant Id
     *
     * @param TenantIdInterface $tenantId
     *
     * @return TenantInterface|null
     */
    public function findById(TenantIdInterface $tenantId): ?TenantInterface;

    /**
     * Insert a Tenant
     *
     * @param TenantInterface $item
     *
     * @return TenantInterface|null
     */
    public function insert(TenantInterface $item): ?TenantInterface;

    /**
     * Update a Tenant
     *
     * @param TenantInterface $item
     *
     * @return TenantInterface|null
     */
    public function update(TenantInterface $item): ?TenantInterface;

    /**
     * Delete a Tenant
     *
     * @param TenantInterface $item
     *
     * @return boolean
     */
    public function delete(TenantInterface $item): bool;
}
