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
 * Tenant Factory Interface
 *
 * @package Base\TenantService\Domain\Model
 */
interface TenantFactoryInterface
{
    /**
     * Create a Tenant
     * @param  TenantIdInterface          $id
     * @param  string|null                $domain
     * @param  bool|boolean               $isRootMember
     * @param  TenantStatusInterface|null $status
     * @param  \DateTime|null             $createdAt
     * @param  \DateTime|null             $updatedAt
     * @return TenantInterface
     */
    public function createTenant(
        TenantIdInterface $id,
        string $domain = null,
        bool $isRootMember = false,
        TenantStatusInterface $status = null,
        \DateTime $createdAt = null,
        \DateTime $updatedAt = null
    ): TenantInterface;

    /**
     * Create a Tenant Id
     *
     * @param string $value
     *
     * @return TenantIdInterface
     */
    public function createTenantId(string $value): TenantIdInterface;

    /**
     * Create a Tenant Id From Name Domain
     *
     * @param string|null $name
     * @param string|null $domain
     *
     * @return TenantIdInterface
     */
    public function createTenantIdFromNameDomain(string $name = null, string $domain = null): TenantIdInterface;

    /**
     * Create a Tenant Status from name
     *
     * @param string $name
     *
     * @return TenantStatusInterface
     */
    public function createTenantStatusFromName(string $name): TenantStatusInterface;

    /**
     * Create a Tenant Status from value
     *
     * @param mixed $value
     *
     * @return TenantStatusInterface
     */
    public function createTenantStatusFromValue($value): TenantStatusInterface;
}
