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
use Base\TenantService\ValueObject\TenantIdInterface;
use Base\TenantService\Factory\TenantFactoryInterface;
use Base\PDO\PDOProxyInterface;
use Base\Exception\ServerErrorException;
use Base\Formatter\DateTimeFormatter;

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
    private $tenantFactory;

    /**
     * @param PDOProxyInterface $pdo
     * @param TenantFactoryInterface $tenantFactory
     */
    public function __construct(PDOProxyInterface $pdo, TenantFactoryInterface $tenantFactory)
    {
        $this->pdo = $pdo;
        $this->tenantFactory = $tenantFactory;
        if (defined('TENANT_SERVICE_CONSTANTS')
        && isset(TENANT_SERVICE_CONSTANTS['TABLE_PREFIX'])
        && !empty(TENANT_SERVICE_CONSTANTS['TABLE_PREFIX'])) {
            $this->tablePrefix = TENANT_SERVICE_CONSTANTS['TABLE_PREFIX'];
        }
    }

    /**
     * {@inheritdoc}
     */
    public function get(TenantIdInterface $tenantId): ?TenantInterface
    {
        try {
            $sql = 'SELECT * FROM '. $this->tablePrefix . 'Tenant t WHERE t.id = :id LIMIT 0,1';
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute(['id' => $tenantId]);
            $result = $stmt->fetch();
            // Convert to the desired return type
            return $this->convertToEntity($result);
        } catch (\PDOException $e) {
            throw new ServerErrorException('Failed Getting Tenant', false, $e->getMessage());
        }
    }

    /**
     * {@inheritdoc}
     */
    public function add(TenantInterface $tenant): ?TenantIdInterface
    {
        try {
            $this->pdo->beginTransaction();
            $sql = 'INSERT INTO ' . $this->tablePrefix . 'Tenant (
                id,
                domain,
                platform,
                status,
                createdAt,
                updatedAt
              ) VALUES (
                :id,
                :domain,
                :platform,
                :status,
                :createdAt,
                :updatedAt
              )';
            $stmt = $this->pdo->prepare($sql);
            $result = $stmt->execute([
              'id' => (string) $tenant->getId(),
              'domain' => (string) $tenant->getDomain(),
              'platform' => (string) $tenant->getPlatform(),
              'status' => (string) $tenant->getStatus(),
              'createdAt' => DateTimeFormatter::toDb($tenant->getCreatedAt()),
              'updatedAt' => DateTimeFormatter::toDb($tenant->getUpdatedAt())
            ]);
            $id = null;
            if ($result) {
                $id = $tenant->getId();
            }
            $this->pdo->commit();
            return $id;
        } catch (\PDOException $e) {
            $this->pdo->rollBack();
            throw new ServerErrorException('Failed Adding Tenant to Storage', false, $e->getMessage());
        }
    }

    /**
     * {@inheritdoc}
     */
    public function convertToEntity($data): ?TenantInterface
    {
        try {
            if (!empty($data)) {
                $tenant = $this->tenantFactory->create();
                $tenantId = $this->tenantFactory->createTenantId();
                foreach ($data as $key => $value) {
                    $setMethod = 'set'.ucfirst($key);
                    if (method_exists($tenant, $setMethod)) {
                        if ($key == 'id') {
                            $tenantId->setId($value);
                            $value = $tenantId;
                        }
                        $dateTimeProperties = [
                          'createdAt',
                          'updatedAt'
                        ];
                        if (in_array($key, $dateTimeProperties)) {
                            $value = DateTimeFormatter::createFromDb($value);
                        }
                        $tenant->$setMethod($value);
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
