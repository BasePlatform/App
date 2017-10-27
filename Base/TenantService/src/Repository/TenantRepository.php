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

use Base\TenantService\ValueObject\TenantId;
use Base\TenantService\Entity\TenantInterface;
use Base\Factory\Factory;
use Base\Factory\FactoryInterface;

/**
 * Tenant Repository
 *
 * @package Base\TenantService\Service
 */
class TenantRepository implements TenantRepositoryInterface
{
  /**
   * @var object
   */
  private $pdo;

  /**
   * @var FactoryInterface
   */
  private $entityFactory;

  /**
   * @param object $pdo
   * @param FactoryInterface $entityFactory
   */
  public function __construct($pdo, FactoryInterface $entityFactory = Factory)
  {
    $this->pdo = $pdo;
    $this->entityFactory = $entityFactory;
  }

  /**
   * Find Tenant by TenantId
   *
   * @param TenantId $tenantId
   *
   * @return TenantInterface
   */
  public function findOneById(TenantId $tenantId)
  {
    $sql = 'SELECT * FROM BaseTenant t
            WHERE t.id = ?';
    $tenant = $this->pdo->query($sql, [(string) $tenantId])->fetch();

  }
}
