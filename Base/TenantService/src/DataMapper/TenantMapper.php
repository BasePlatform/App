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

namespace Base\TenantService\DataMapper;

use Base\TenantService\Model\TenantInterface;
use Base\TenantService\Model\TenantIdInterface;
use Base\TenantService\Model\TenantFactoryInterface;
use Base\Db\DbAdapterInterface;
use Base\Exception\ServerErrorException;
use Base\Helper\DateTimeHelper;

/**
 * Tenant Mapper
 *
 * @package Base\TenantService\DataMapper
 */
class TenantMapper implements TenantMapperInterface
{
    /**
     * @var string
     */
    protected $table = 'Tenant';

    /**
     * @var TenantFactoryInterface
     */
    protected $factory;

    /**
     * @param DbAdapterInterface $dbAdapter
     * @param TenantFactoryInterface $factory
     * @param string|null $entityInterface
     */
    public function __construct(DbAdapterInterface $dbAdapter, TenantFactoryInterface $factory, string $entityInterface = null)
    {
        $this->dbAdapter = $dbAdapter;
        $this->factory = $factory;
        $this->entityInterface = $entityInterface ?: \Base\TenantService\Model\TenantInterface::class;
        if (defined('TENANT_SERVICE_CONSTANTS')
        && isset(TENANT_SERVICE_CONSTANTS['TABLE_PREFIX'])
        && !empty(TENANT_SERVICE_CONSTANTS['TABLE_PREFIX'])) {
            $this->table = TENANT_SERVICE_CONSTANTS['TABLE_PREFIX'].$this->table;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function fetchById(TenantIdInterface $tenantId): ?TenantInterface
    {
        $sql = 'SELECT * FROM '. $this->table . 't WHERE t.id = :id LIMIT 0,1';
        $stmt = $this->dbAdapter->prepare($sql);
        $stmt->execute(['id' => $tenantId->toString()]);
        $result = $stmt->fetch();
        return $this->convertToEntity($result);
    }

    /**
     * {@inheritdoc}
     */
    public function insert(TenantInterface $item): ?TenantInterface
    {
        $sql = 'INSERT INTO ' . $this->table . ' (
          id,
          domain,
          platform,
          isRootMember,
          status,
          createdAt,
          updatedAt
        ) VALUES (
          :id,
          :domain,
          :platform,
          :isRootMember,
          :status,
          :createdAt,
          :updatedAt
        )';
        $stmt = $this->dbAdapter->prepare($sql);
        $result = $stmt->execute([
          'id' => (string) $item->getId(),
          'domain' => $item->getDomain(),
          'platform' => $item->getPlatform(),
          'isRootMember' => $item->getIsRootMember(),
          'status' => (string) $item->getStatus()->getValue(),
          'createdAt' => DateTimeHelper::toDb($item->getCreatedAt()),
          'updatedAt' => DateTimeHelper::toDb($item->getUpdatedAt())
        ]);
        return $result ? $item : null;
    }

    /**
     * {@inheritdoc}
     */
    public function update(TenantInterface $item): ?TenantInterface
    {
        $sql = 'UPDATE ' . $this->table . ' t SET
          domain = :domain,
          platform = :platform,
          isRootMember = :isRootMember,
          status = :status,
          createdAt = :createdAt,
          updatedAt :updatedAt
        WHERE t.id = :id LIMIT 1';
        $stmt = $this->dbAdapter->prepare($sql);
        $result = $stmt->execute([
          'id' => (string) $item->getId(),
          'domain' => $item->getDomain(),
          'platform' => $item->getPlatform(),
          'isRootMember' => $item->getIsRootMember(),
          'status' => (string) $item->getStatus()->getValue(),
          'createdAt' => DateTimeHelper::toDb($item->getCreatedAt()),
          'updatedAt' => DateTimeHelper::toDb($item->getUpdatedAt())
        ]);
        return $result ? $item : null;
    }

    /**
     * {@inheritdoc}
     */
    public function delete(TenantInterface $item): bool
    {
        $sql = 'DELETE FROM ' . $this->table . ' t WHERE
                t.id = :id';
        $stmt = $this->dbAdapter->prepare($sql);
        $result = $stmt->execute([
          'id' => (string) $item->getId()
        ]);
        return $result;
    }

    /**
     * {@inheritdoc}
     */
    public function convertToEntity($data): ?TenantInterface
    {
        if (!empty($data)) {
            $entity = $this->factory->create();
            foreach ($data as $key => $value) {
                $setMethod = 'set'.ucfirst($key);
                if (method_exists($entity, $setMethod) && $value != null) {
                    if ($key == 'id') {
                        $value = $this->factory->createTenantId($value);
                    }
                    if ($key == 'status') {
                        $value = $this->factory->createTenantStatus($value, true);
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
    }
}
