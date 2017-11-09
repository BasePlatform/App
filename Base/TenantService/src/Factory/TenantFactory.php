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
use Base\TenantService\Entity\TenantInterface;
use Base\TenantService\ValueObject\TenantIdInterface;

/**
 * Tenant Factory
 *
 * @package Base\TenantService\Factory
 */
class TenantFactory implements TenantFactoryInterface
{
    /**
     * @var FactoryInterface
     */
    private $factory;

    /**
     * @var FactoryInterface
     */
    private $tenantIdFactory;

    /**
     * @param FactoryInterface $factory
     * @param FactoryInterface $tenantIdFactory
     */
    public function __construct(FactoryInterface $factory, FactoryInterface $tenantIdFactory)
    {
        $this->factory = $factory;
        $this->tenantIdFactory = $tenantIdFactory;
    }

    /**
     * @return TenantInterface
     */
    public function create(): TenantInterface
    {
        return $this->factory->create();
    }

    /**
     * @return TenantIdInterface
     */
    public function createTenantId(): TenantIdInterface
    {
        return $this->tenantIdFactory->create();
    }

    /**
     * {@inheritdoc}
     */
    public function getClassName(): string
    {
        return $this->factory->getClassName();
    }

    /**
     * {@inheritdoc}
     */
    public function getTenantIdClassName(): string
    {
        return $this->tenantIdFactory->getClassName();
    }
}
