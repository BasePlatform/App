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

use Base\TenantService\Domain\Model\TenantInterface;
use Base\TenantService\Domain\Model\TenantIdInterface;
use Base\TenantService\Domain\Model\TenantStatusInterface;

/**
 * Tenant Factory
 *
 * @package Base\TenantService\Domain\Model
 */
class TenantFactory implements TenantFactoryInterface
{
    /**
     * @var string
     */
    private $tenantClass;

    /**
     * @var string
     */
    private $tenantCollectionClass;

    /**
     * @var string
     */
    private $tenantIdClass;

    /**
     * @var string
     */
    private $tenantStatusClass;

    /**
     * @param string $tenantClass
     * @param string $tenantCollectionClass
     * @param string $tenantIdClass
     * @param string $tenantStatusClass
     */
    public function __construct(
        string $tenantClass,
        string $tenantCollectionClass,
        string $tenantIdClass,
        string $tenantStatusClass
    ) {
        $this->tenantClass = $tenantClass;
        $this->tenantCollectionClass = $tenantCollectionClass;
        $this->tenantIdClass = $tenantIdClass;
        $this->tenantStatusClass = $tenantStatusClass;
    }

    /**
     * {@inheritdoc}
     */
    public function createTenant(): TenantInterface
    {
        return new $this->tenantClass();
    }

    /**
     * {@inheritdoc}
     */
    public function createTenantId(string $value): TenantIdInterface
    {
        return new $this->tenantIdClass($value);
    }

    /**
     * {@inheritdoc}
     */
    public function createTenantIdFromNameDomain(string $name = null, string $domain = null): TenantIdInterface
    {
        return call_user_func_array([$this->tenantIdClass, 'createFromNameDomain'], [$name, $value]);
    }

    /**
     * {@inheritdoc}
     */
    public function createTenantStatusFromName(string $name): TenantStatusInterface
    {
        return call_user_func_array([$this->tenantStatusClass, 'create'], [$name]);
    }

    /**
     * {@inheritdoc}
     */
    public function createTenantStatusFromValue($value): TenantStatusInterface
    {
        return call_user_func_array([$this->tenantStatusClass, 'createFromValue'], [$value]);
    }
}
