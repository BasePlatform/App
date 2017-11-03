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

use Base\TenantService\ValueObject\TenantIdInterface;
use Base\TenantService\Entity\TenantInterface;
use Base\PDO\PDOProxyInterface;
use Base\TenantService\Factory\TenantFactory;
use Base\TenantService\Factory\TenantIdFactory;
use Base\Exception\ServerErrorException;

/**
 * Tenant Repository
 *
 * @package Base\TenantService\Repository
 */
class TenantRepository implements TenantRepositoryInterface
{
  /**
   * @var PDOProxyInterface
   */
  private $pdo;

  /**
   * @var TenantFactory
   */
  private $tenantFactory;

  /**
   * @var TenantIdFactory
   */
  private $tenantIdFactory;

  /**
   * @param PDOProxyInterface $pdo
   * @param FactoryInterface $entityFactory
   */
  public function __construct(PDOProxyInterface $pdo, TenantFactory $tenantFactory, TenantIdFactory $tenantIdFactory)
  {
    $this->pdo = $pdo;
    $this->tenantFactory = $tenantFactory;
    $this->tenantIdFactory = $tenantIdFactory;
  }

  /**
   * {@inheritdoc}
   */
  public function findOneById(TenantIdInterface $tenantId): ?TenantInterface
  {
    try {
      $stmt = $this->pdo->prepare('SELECT * FROM BaseTenant t WHERE t.id = :id limit 0,1');
      $stmt->execute(['id' => (string) $tenantId]);
      // Return which type
      $result = $stmt->fetch();
      // Convert to the desired return type
      return $this->convertToEntity($result);
    } catch(\PDOException $e) {
      throw new ServerErrorException('Failed Querying findOneById Tenant', false, $e->getMessage());
    }
  }

  /**
   * {@inheritdoc}
   */
  public function convertToEntity($data): ?TenantInterface
  {
    try {
      if (!empty($data)) {
        $tenant = $this->tenantFactory->createNew();
        $tenantId = $this->tenantIdFactory->createNew();
        foreach ($data as $key=>$value) {
          if ($key == 'id') {
            $tenantId->setId($value);
            $tenant->setId($tenantId);
          } else {
            $setMethod = 'set'.ucfirst($key);
            if (method_exists($tenant, $setMethod)) {
              $tenant->$setMethod($value);
            }
          }
        }
        return $tenant;
      } else {
        return null;
      }
    } catch (\Exception $e) {
      throw new ServerErrorException('Failed Converting Data To Tenant Entity', false, $e->getMessage());
    }
  }
}
