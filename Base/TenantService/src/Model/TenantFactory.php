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
 * Tenant Factory
 *
 * @package Base\TenantService\Model
 */
class TenantFactory implements TenantFactoryInterface
{
    use \Base\Factory\FactoryTrait;

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
     * @param string $class
     * @param string $tenantCollectionClass
     * @param string $tenantIdClass
     * @param string $tenantStatusClass
     */
    public function __construct(
        string $class = null,
        string $tenantCollectionClass = null,
        string $tenantIdClass = null,
        string $tenantStatusClass = null
    ) {
        $this->class = $class ?: \Base\TenantService\Model\Tenant::class;
        $this->tenantCollectionClass = $tenantCollectionClass ?: \Base\TenantService\Model\TenantCollection::class;
        $this->tenantIdClass = $tenantIdClass ?: \Base\TenantService\Model\TenantId::class;
        $this->tenantStatusClass = $tenantStatusClass ?: \Base\TenantService\Model\TenantStatus::class;
    }

    /**
     * {@inheritdoc}
     */
    public function createTenantCollection(): TenantCollectionInterface
    {
        return new $this->tenantCollectionClass();
    }

    /**
     * {@inheritdoc}
     */
    public function createTenantId(string $value = null): TenantIdInterface
    {
        return new $this->tenantIdClass($value);
    }

    /**
     * {@inheritdoc}
     */
    public function createTenantStatus($value = null, $createFromValue = false): TenantStatusInterface
    {
        if (!$value) {
            return new $this->tenantStatusClass();
        } else {
            if ($createFromValue) {
                return call_user_func_array([$this->tenantStatusClass(), 'createFromValue'], [$value]);
            } else {
                return call_user_func_array([$this->tenantStatusClass(), 'create'], [$value]);
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getTenantCollectionClass(): string
    {
        return $this->tenantCollectionClass;
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
