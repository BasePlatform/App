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
use Base\TenantService\ValueObject\TenantIdInterface;

/**
 * Tenant Factory Interface
 *
 * @package Base\TenantService\Factory
 */
interface TenantFactoryInterface extends FactoryInterface
{
    /**
     * Create an instance of TenantIdInterface
     *
     * @return TenantIdInterface
     */
    public function createTenantId(): TenantIdInterface;

    /**
     * Return the class name of TenantId Factory
     *
     * @return string
     */
    public function getTenantIdClassName(): string;
}
