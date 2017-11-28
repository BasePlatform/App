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

namespace Base\TenantService\Model;

use Base\Factory\FactoryInterface;

/**
 * Tenant Factory Interface
 *
 * @package Base\TenantService\Model
 */
interface TenantFactoryInterface extends FactoryInterface
{
    /**
     * Create a Tenant Collection from the class
     *
     * @return \Base\TenantService\Model\TenantCollectionInterface
     */
    public function createTenantCollection(): TenantCollectionInterface;

    /**
     * Create a Tenant Id from the class
     *
     * @param string|null $value
     *
     * @return \Base\TenantService\Model\TenantIdInterface
     */
    public function createTenantId(string $value = null): TenantIdInterface;

    /**
     * Create a Tenant Status from the class
     *
     * @param mixed|null $value
     * @param boolean $createFromvalue
     *
     * @return \Base\TenantService\Model\TenantStatusInterface
     */
    public function createTenantStatus($value = null, $createFromValue = false): TenantStatusInterface;

    /**
     * Get class of TenantCollection
     *
     * @return string
     */
    public function getTenantCollectionClass(): string;

    /**
     * Get class of TenantId
     *
     * @return string
     */
    public function getTenantIdClass(): string;

    /**
     * Get class of TenantStatus
     *
     * @return string
     */
    public function getTenantStatusClass(): string;
}
