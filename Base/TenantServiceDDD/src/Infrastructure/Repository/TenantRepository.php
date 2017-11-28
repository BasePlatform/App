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

namespace Base\TenantService\Repository;

use Base\TenantService\Infrastructure\DataMapper\TenantMapperInterface;
use Base\TenantService\Domain\Model\TenantIdInterface;
use Base\TenantService\Domain\Model\TenantInterface;

/**
 * Tenant Repository
 *
 * @package Base\TenantService\Repository
 */
class TenantRepository implements TenantRepositoryInterface
{
    /**
     * @var TenantMapperInterface
     */
    private $dataMapper;

    /**
     * @param TenantMapperInterface $dataMapper
     */
    public function __construct(TenantMapperInterface $dataMapper)
    {
        $this->dataMapper = $dataMapper;
    }

    /**
     * {@inheritdoc}
     */
    public function get(TenantIdInterface $tenantId): ?TenantInterface
    {
        return $this->dataMapper->fetchById($tenantId);
    }
}