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

namespace Base\AuthService\Repository;

use Base\AuthService\Entity\UserInterface;
use Base\AuthService\ValueObject\ZoneInterface;
use Base\AuthService\Factory\UserFactoryInterface;
use Base\AuthService\Factory\ZoneFactoryInterface;
use Base\PDO\PDOProxyInterface;
use Base\Exception\ServerErrorException;
use Base\Helper\DateTimeHelper;

/**
 * User Repository
 *
 * @package Base\AuthService\Repository
 */
class UserRepository implements UserRepositoryInterface
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
     * @var UserFactoryInterface
     */
    private $factory;

    /**
     * @var ZoneFactoryInterface
     */
    private $zoneFactory;

    /**
     * @param PDOProxyInterface $pdo
     * @param UserFactoryInterface $factory
     * @param ZoneFactoryInterface $zoneFactory
     */
    public function __construct(PDOProxyInterface $pdo, UserFactoryInterface $factory, ZoneFactoryInterface $zoneFactory)
    {
        $this->pdo = $pdo;
        $this->factory = $factory;
        $this->zoneFactory = $zoneFactory;
        if (defined('AUTH_SERVICE_CONSTANTS')
            && isset(AUTH_SERVICE_CONSTANTS['TABLE_PREFIX'])
            && !empty(AUTH_SERVICE_CONSTANTS['TABLE_PREFIX'])) {
            $this->tablePrefix = AUTH_SERVICE_CONSTANTS['TABLE_PREFIX'];
        }
    }

    /**
     * {@inheritdoc}
     */
    public function find(string $tenantId, int $userId, bool $withTrashed = false): ?UserInterface
    {
        try {
            $sql = 'SELECT * FROM '. $this->tablePrefix . 'User u WHERE
                u.tenantId = :tenantId AND
                u.userId = :userId';
            if (!$withTrashed) {
                $sql.= ' AND u.deletedAt = null';
            }
            $sql.= ' LIMIT 0,1';
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
              'tenantId' => $tenantId,
              'userId' => $userId
            ]);
            $result = $stmt->fetch();
            // Convert to the desired return type
            return $this->convertToEntity($result);
        } catch (\PDOException $e) {
            throw new ServerErrorException(sprintf('Failed Finding User `%s` Of Tenant `%s`', (string) $userId, $tenantId), false, $e->getMessage());
        }
    }

    /**
     * {@inheritdoc}
     */
    public function findByZoneAndEmail(string $tenantId, string $email, ZoneInterface $zone, bool $withTrashed = false): ?UserInterface
    {
        try {
            $sql = 'SELECT * FROM '. $this->tablePrefix . 'User u WHERE
                u.tenantId = :tenantId AND
                u.email = :email,
                u.zone = :zone';
            if (!$withTrashed) {
                $sql.= ' AND u.deletedAt = null';
            }
            $sql.= ' LIMIT 0,1';
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
              'tenantId' => $tenantId,
              'email' => $email,
              'zone' => (string) $zone,
            ]);
            $result = $stmt->fetch();
            // Convert to the desired return type
            return $this->convertToEntity($result);
        } catch (\PDOException $e) {
            throw new ServerErrorException(sprintf('Failed Finding User By Email `%s` In Zone `%s` Of Tenant `%s`', (string) $email, (string) $zone, $tenantId), false, $e->getMessage());
        }
    }

    /**
     * {@inheritdoc}
     */
    public function findByZoneAndUserName(string $tenantId, string $userName, ZoneInterface $zone, bool $withTrashed = false): ?UserInterface
    {
        try {
            $sql = 'SELECT * FROM '. $this->tablePrefix . 'User u WHERE
                u.tenantId = :tenantId AND
                u.userName = :userName,
                u.zone = :zone';
            if (!$withTrashed) {
                $sql.= ' AND u.deletedAt = null';
            }
            $sql.= ' LIMIT 0,1';
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
              'tenantId' => $tenantId,
              'userName' => $userName,
              'zone' => (string) $zone,
            ]);
            $result = $stmt->fetch();
            // Convert to the desired return type
            return $this->convertToEntity($result);
        } catch (\PDOException $e) {
            throw new ServerErrorException(sprintf('Failed Finding User By UserName `%s` In Zone `%s` Of Tenant `%s`', (string) $userName, (string) $zone, $tenantId), false, $e->getMessage());
        }
    }

    /**
     * {@inheritdoc}
     */
    public function insert(UserInterface $item): ?UserInterface
    {
        try {
            $this->pdo->beginTransaction();
            $sql = 'INSERT INTO ' . $this->tablePrefix . 'User (
                tenantId,
                zone,
                email,
                userName,
                displayName,
                tagLine,
                avatar,
                status,
                createdAt,
                updatedAt
              ) VALUES (
                :tenantId,
                :zone,
                :email,
                :userName,
                :displayName,
                :tagLine,
                :avatar,
                :status,
                :createdAt,
                :updatedAt
              )';
            $stmt = $this->pdo->prepare($sql);
            $result = $stmt->execute([
              'tenantId' => $item->getTenantId(),
              'zone' => (string) $item->getZone(),
              'email' => $item->getEmail(),
              'userName' => $item->getUserName(),
              'displayName' => $item->getDisplayName(),
              'tagLine' => $item->getTagLine(),
              'avatar' => $item->getAvatar(),
              'status' => $item->getStatus(),
              'createdAt' => DateTimeHelper::toDb($item->getCreatedAt()),
              'updatedAt' => DateTimeHelper::toDb($item->getUpdatedAt())
            ]);
            if ($result) {
                $id = (int) $this->pdo->lastInsertId();
                $this->pdo->commit();
                $item->setId($id);
                return $item;
            } else {
                $this->pdo->rollBack();
                return null;
            }
        } catch (\PDOException $e) {
            $this->pdo->rollBack();
            throw new ServerErrorException('Failed Adding User Information', false, $e->getMessage());
        }
    }

    /**
     * {@inheritdoc}
     */
    public function update(UserInterface $item): ?UserInterface
    {
        try {
            $this->pdo->beginTransaction();
            $sql = 'UPDATE ' . $this->tablePrefix . 'User u SET
                tenantId = :tenantId,
                zone = :zone,
                email = :email,
                userName = :userName,
                displayName = :displayName,
                tagLine = :tagLine,
                avatar = :avatar,
                status = :status,
                createdAt = :createdAt,
                updatedAt = :updatedAt
              WHERE u.id = :id LIMIT 1';
            $stmt = $this->pdo->prepare($sql);
            $result = $stmt->execute([
              'id' => (int) $item->getId(),
              'tenantId' => $item->getTenantId(),
              'zone' => (string) $item->getZone(),
              'email' => $item->getEmail(),
              'userName' => $item->getUserName(),
              'displayName' => $item->getDisplayName(),
              'tagLine' => $item->getTagLine(),
              'avatar' => $item->getAvatar(),
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
            throw new ServerErrorException('Failed Updating User Information', false, $e->getMessage());
        }
    }

    /**
     * {@inheritdoc}
     */
    public function softDelete(string $tenantId, int $userId): bool
    {
        try {
            $this->pdo->beginTransaction();
            $sql = 'UPDATE ' . $this->tablePrefix . 'User u SET
                deletedAt = :time WHERE
                  u.tenantId = :tenantId AND
                  u.id = :id
                LIMIT 1';
            $stmt = $this->pdo->prepare($sql);
            $result = $stmt->execute([
              'time' => DateTimeHelper::now(DateTimeHelper::DB_DATETIME_FORMAT),
              'tenantId' => $tenantId,
              'id' => $userId,
            ]);
              $this->pdo->commit();
              return $result;
        } catch (\PDOException $e) {
            $this->pdo->rollBack();
            throw new ServerErrorException(sprintf('Failed Soft Deleting User `%s` Of Tenant `%s`', (string) $userId, $tenantId), false, $e->getMessage());
        }
    }

    /**
     * {@inheritdoc}
     */
    public function recover(string $tenantId, int $userId): bool
    {
        try {
            $this->pdo->beginTransaction();
            $sql = 'UPDATE ' . $this->tablePrefix . 'User u SET
                deletedAt = null WHERE
                  u.tenantId = :tenantId AND
                  u.id = :id
                LIMIT 1';
            $stmt = $this->pdo->prepare($sql);
            $result = $stmt->execute([
              'tenantId' => $tenantId,
              'id' => $userId,
            ]);
              $this->pdo->commit();
              return $result;
        } catch (\PDOException $e) {
            $this->pdo->rollBack();
            throw new ServerErrorException(sprintf('Failed Recovering User `%s` Of Tenant `%s`', (string) $userId, $tenantId), false, $e->getMessage());
        }
    }

    /**
     * {@inheritdoc}
     */
    public function convertToEntity($data): ?UserInterface
    {
        try {
            if (!empty($data)) {
                $entity = $this->factory->create();
                foreach ($data as $key => $value) {
                    $setMethod = 'set'.ucfirst($key);
                    if (method_exists($entity, $setMethod) && $value != null) {
                        if ($key == 'zone') {
                            $zone = $this->zoneFactory->create();
                            $zone->setZoneId($value);
                            $value = $zone;
                        }
                        $dateTimeProperties = [
                          'createdAt',
                          'updatedAt',
                          'deletedAt'
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
            throw new ServerErrorException('Failed Converting Data To User Entity', false, $e->getMessage());
        }
    }
}
