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
use Base\PDO\PDOProxyInterface;

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
   * @param PDOProxyInterface $pdo
   * @param FactoryInterface $entityFactory
   */
  public function __construct(PDOProxyInterface $pdo)
  {
    $this->pdo = $pdo;
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
    $stmt = $this->pdo->prepare('SELECT * FROM BaseTenant t WHERE t.id = :id limit 0,1');
    $stmt->execute(['id' => (string) $tenantId]);
    return $stmt->fetch();
  }
}
