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
use Base\TenantService\Model\TenantIdInterface;
use Base\TenantService\Model\TenantStatusInterface;

/**
 * Tenant Factory
 *
 * @package Base\TenantService\Factory
 */
class TenantFactory implements TenantFactoryInterface
{
    use \Base\Factory\FactoryTrait;

    /**
     * @var string
     */
    private $tenantIdClass;

    /**
     * @var string
     */
    private $tenantStatusClass;

    /**
     * @param string $class
     */
    public function __construct(string $class = null, string $tenantIdClass = null, string $tenantStatusClass = null)
    {
        $this->class = $class ? $class : \Base\TenantService\Model\Tenant::class;
        $this->tenantIdClass = $tenantIdClass ? $tenantIdClass : \Base\TenantService\Model\TenantId::class;
        $this->tenantStatusClass = $tenantStatusClass ? $tenantStatusClass : \Base\TenantService\Model\TenantStatus::class;
    }

    /**
     * Create a Tenant Id from the class
     *
     * @return \Base\TenantService\Model\TenantIdInterface
     */
    /**
     * {@inheritdoc}
     */
    public function createTenantId(): TenantIdInterface
    {
        return new $this->tenantIdClass();
    }

    /**
     * Create a Tenant Status from the class
     *
     * @return \Base\TenantService\Model\TenantStatusInterface
     */
    /**
     * {@inheritdoc}
     */
    public function createTenantStatus(): TenantStatusInterface
    {
        return new $this->tenantStatusClass();
    }

    /**
     * {@inheritdoc}
     */
    public function getTenantIdClass(): string
    {
        return $this->tenantIdClass;
    }

    /**
     * {@inheritdoc}
     */
    public function getTenantStatusClass(): string
    {
        return $this->tenantStatusClass;
    }
}
