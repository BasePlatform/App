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

namespace Base\TenantService\Domain\Model;

/**
 * Tenant Repository Interface
 *
 * @package Base\TenantService\Domain\Model
 */
interface TenantRepositoryInterface
{
    /**
     * Get Tenant by Tenant Id
     *
     * @param TenantIdInterface $tenantId
     *
     * @return TenantInterface|null
     */
    public function get(TenantIdInterface $tenantId): ?TenantInterface;
}
