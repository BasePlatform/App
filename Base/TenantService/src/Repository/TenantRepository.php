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

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Base\TenantService\ValueObject\TenantId;
/**
 * Tenant Repository with Doctrine
 *
 * @package Base\TenantService\Repository
 */
class TenantRepository extends EntityRepository implements TenantRepositoryInterface
{
    /**
     * Find a Tenant by Id
     *
     * @param TenantId $tenantId
     *
     * @return Tenant
     */
    public function findOneById(TenantId $tenantId): Tenant
    {
        $queryBuilder = $this->createQueryBuilder($alias = 'wallet');
        return $this->createOperatorPaginator($queryBuilder, $alias, $filters, $operators, $values, $sort);
    }

    /**
     * @param array $filters
     * @param array $operators
     * @param array $values
     * @param array $sort
     *
     * @return \Pagerfanta\Pagerfanta|Wallet[]
     */
    public function findAll(array $filters = [], array $operators = [], array $values = [], array $sort = [])
    {
        $queryBuilder = $this->createQueryBuilder($alias = 'wallet');
        return $this->createOperatorPaginator($queryBuilder, $alias, $filters, $operators, $values, $sort);
    }

    /**
     * @param WalletId $uid
     * @return Wallet
     * @throws WalletNotFoundException
     */
    public function save(WalletId $uid): Wallet
    {
        $wallet = $this->findOneById($uid);
        if (!$wallet) {
            throw new WalletNotFoundException();
        }
        return $wallet;
    }
}