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

use Base\TenantService\Entity\TenantInterface;
use Base\TenantService\Factory\TenantFactoryInterface;
use Base\PDO\PDOProxyInterface;
use Base\Exception\ServerErrorException;
use Base\Helper\DateTimeHelper;

/**
 * Tenant Repository
 *
 * @package Base\TenantService\Repository
 */
class TenantRepository implements TenantRepositoryInterface
{
    /**
     * @var string
     */
    private $tablePrefix = '';

    /**
     * @var PDOProxyInterface
     */
    private $pdo;

    /**
     * @var TenantFactoryInterface
     */
    private $factory;

    /**
     * @param PDOProxyInterface $pdo
     * @param TenantFactoryInterface $factory
     */
    public function __construct(PDOProxyInterface $pdo, TenantFactoryInterface $factory)
    {
        $this->pdo = $pdo;
        $this->factory = $factory;
        if (defined('TENANT_SERVICE_CONSTANTS')
        && isset(TENANT_SERVICE_CONSTANTS['TABLE_PREFIX'])
        && !empty(TENANT_SERVICE_CONSTANTS['TABLE_PREFIX'])) {
            $this->tablePrefix = TENANT_SERVICE_CONSTANTS['TABLE_PREFIX'];
        }
    }

    /**
     * {@inheritdoc}
     */
    public function find(TenantIdInterface $tenantId): ?TenantInterface
    {
        try {
            $sql = 'SELECT * FROM '. $this->tablePrefix . 'Tenant t WHERE t.id = :id LIMIT 0,1';
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute(['id' => $tenantId]);
            $result = $stmt->fetch();
            // Convert to the desired return type
            return $this->convertToEntity($result);
        } catch (\PDOException $e) {
            throw new ServerErrorException(sprintf('Failed Getting Tenant `%s`', (string) $tenantId), false, $e->getMessage());
        }
    }

    /**
     * {@inheritdoc}
     */
    public function insert(TenantInterface $item): ?TenantInterface
    {
        try {
            $this->pdo->beginTransaction();
            $sql = 'INSERT INTO ' . $this->tablePrefix . 'Tenant (
                id,
                domain,
                platform,
                timeZone,
                status,
                createdAt,
                updatedAt
              ) VALUES (
                :id,
                :domain,
                :platform,
                :timeZone,
                :status,
                :createdAt,
                :updatedAt
              )';
            $stmt = $this->pdo->prepare($sql);
            $result = $stmt->execute([
              'id' => (string) $item->getId(),
              'domain' => $item->getDomain(),
              'platform' => $item->getPlatform(),
              'timeZone' => $item->getTimeZone(),
              'status' => $item->getStatus(),
              'createdAt' => DateTimeHelper::toDb($item->getCreatedAt()),
              'updatedAt' => DateTimeHelper::toDb($item->getUpdatedAt())
            ]);
            if ($result) {
                $this->pdo->commit();
                return $item;
            } else {
                $this->pdo->rollBack();
                return null;
            }
        } catch (\PDOException $e) {
            $this->pdo->rollBack();
            throw new ServerErrorException('Failed Adding Tenant Information', false, $e->getMessage());
        }
    }

    /**
     * {@inheritdoc}
     */
    public function convertToEntity($data): ?TenantInterface
    {
        try {
            if (!empty($data)) {
                $entity = $this->factory->create();
                foreach ($data as $key => $value) {
                    $setMethod = 'set'.ucfirst($key);
                    if (method_exists($entity, $setMethod) && $value != null) {
                        if ($key == 'id') {
                            $tenantId = $this->factory->createTenantId();
                            $tenantId->setId($value);
                            $value = $tenantId;
                        }
                        $dateTimeProperties = [
                          'createdAt',
                          'updatedAt'
                        ];
                        if (in_array($key, $dateTimeProperties)) {
                            $value = DateTimeHelper::createFromDb($value);
                        }
                        $entity->$setMethod($value);
                    }
                }
                return $entity;
            } else {
                return null;
            }
        } catch (\Exception $e) {
            throw new ServerErrorException('Failed Converting Data To Tenant Entity', false, $e->getMessage());
        }
    }
}
