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

namespace Base\TenantService\Factory;

use Base\Factory\FactoryInterface;

/**
 * Tenant Factory Interface
 *
 * @package Base\TenantService\Factory
 */
interface TenantFactoryInterface extends FactoryInterface
{
    /**
     * Create a Tenant Id from the class
     *
     * @return \Base\TenantService\Model\TenantIdInterface
     */
    public function createTenantId(): TenantIdInterface;

    /**
     * Create a Tenant Status from the class
     *
     * @return \Base\TenantService\Model\TenantStatusInterface
     */
    public function createTenantStatus(): TenantStatusInterface;

    /**
     * Create class of TenantId
     *
     * @return string
     */
    public function getTenantIdClass(): string;

    /**
     * Create class of TenantStatus
     *
     * @return string
     */
    public function getTenantStatusClass(): string;
}
