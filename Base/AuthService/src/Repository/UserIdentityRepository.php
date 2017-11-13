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

use Base\AuthService\Entity\UserIdentityInterface;
use Base\AuthService\Factory\UserIdentityFactoryInterface;
use Base\PDO\PDOProxyInterface;
use Base\Exception\ServerErrorException;
use Base\Helper\DateTimeHelper;

/**
 * User Identity Repository
 *
 * @package Base\AuthService\Repository
 */
class UserIdentityRepository implements UserIdentityRepositoryInterface
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
     * @var UserIdentityFactoryInterface
     */
    private $factory;

    /**
     * @param PDOProxyInterface $pdo
     * @param UserIdentityFactoryInterface $factory
     */
    public function __construct(PDOProxyInterface $pdo, UserIdentityFactoryInterface $factory)
    {
        $this->pdo = $pdo;
        $this->factory = $factory;
        if (defined('AUTH_SERVICE_CONSTANTS')
            && isset(AUTH_SERVICE_CONSTANTS['TABLE_PREFIX'])
            && !empty(AUTH_SERVICE_CONSTANTS['TABLE_PREFIX'])) {
            $this->tablePrefix = AUTH_SERVICE_CONSTANTS['TABLE_PREFIX'];
        }
    }

    /**
     * {@inheritdoc}
     */
    public function find(string $tenantId, int $userId): ?UserIdentityInterface
    {
        try {
            $sql = 'SELECT * FROM '. $this->tablePrefix . 'UserIdentity ui WHERE
                ui.tenantId = :tenantId AND
                ui.userId = :userId
              LIMIT 0,1';
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
              'tenantId' => $tenantId,
              'userId' => $userId
            ]);
            $result = $stmt->fetch();
            // Convert to the desired return type
            return $this->convertToEntity($result);
        } catch (\PDOException $e) {
            throw new ServerErrorException(sprintf('Failed Finding User Identity `%s` Of Tenant `%s`', (string) $userId, $tenantId), false, $e->getMessage());
        }
    }

    /**
     * {@inheritdoc}
     */
    public function add(UserIdentityInterface $item): ?int
    {
        try {
            $this->pdo->beginTransaction();
            $sql = 'INSERT INTO ' . $this->tablePrefix . 'UserIdentity (
                tenantId,
                userId,
                authProvider,
                authProviderUid,
                passwordHash,
                authParams,
                recentPasswordUpdateAt,
                updatedAt,
              ) VALUES (
                :tenantId,
                :userId,
                :authProvider,
                :authProviderUid,
                :passwordHash,
                :authParams,
                :recentPasswordUpdateAt,
                :updatedAt
              )';
            $stmt = $this->pdo->prepare($sql);
            $result = $stmt->execute([
              'tenantId' => $item->getTenantId(),
              'userId' => (int) $item->getUserId(),
              'authProvider' => $item->getAuthProvider(),
              'authProviderUid' => $item->getAuthProviderUid(),
              'passwordHash' => ($item->getPasswordHash() != null) ? (string) $item->getPasswordHash() : null,
              'authParams' => ($item->getAuthParams() != null) ? json_encode($item->getAuthParams()) : null,
              'recentPasswordUpdateAt' => DateTimeFormatter::toDb($item->getRecentPasswordUpdateAt()),
              'updatedAt' => DateTimeFormatter::toDb($item->getUpdatedAt())
            ]);
            $id = null;
            if ($result) {
                $id = (int) $this->pdo->lastInsertId();
            }
            $this->pdo->commit();
            return $id;
        } catch (\PDOException $e) {
            $this->pdo->rollBack();
            throw new ServerErrorException('Failed Adding User Identity Information', false, $e->getMessage());
        }
    }

    /**
     * {@inheritdoc}
     */
    public function update(UserIdentityInterface $item): bool
    {
        try {
            $this->pdo->beginTransaction();
            $sql = 'UPDATE ' . $this->tablePrefix . 'UserIdentity ui SET
                tenantId = :tenantId,
                userId = :userId,
                authProvider = :authProvider,
                authProviderUid = :authProviderUid,
                passwordHash = :passwordHash,
                authParams = :authParams,
                recentPasswordUpdateAt = :recentPasswordUpdateAt,
                updatedAt = :updatedAt
              WHERE ui.id = :id LIMIT 1';
            $stmt = $this->pdo->prepare($sql);
            $result = $stmt->execute([
              'id' => (int) $item->getId(),
              'tenantId' => $item->getTenantId(),
              'userId' => (int) $item->getUserId(),
              'authProvider' => $item->getAuthProvider(),
              'authProviderUid' => $item->getAuthProviderUid(),
              'passwordHash' => ($item->getPasswordHash() != null) ? (string) $item->getPasswordHash() : null,
              'authParams' => ($item->getAuthParams() != null) ? json_encode($item->getAuthParams()) : null,
              'recentPasswordUpdateAt' => DateTimeFormatter::toDb($item->getRecentPasswordUpdateAt()),
              'updatedAt' => DateTimeFormatter::toDb($item->getUpdatedAt())
            ]);
            $this->pdo->commit();
            return $result;
        } catch (\PDOException $e) {
            $this->pdo->rollBack();
            throw new ServerErrorException('Failed Updating User Identity Information', false, $e->getMessage());
        }
    }

    /**
     * {@inheritdoc}
     */
    public function convertToEntity($data): ?UserIdentityInterface
    {
        try {
            if (!empty($data)) {
                $entity = $this->factory->create();
                foreach ($data as $key => $value) {
                    $setMethod = 'set'.ucfirst($key);
                    if (method_exists($entity, $setMethod) && $value != null) {
                        if ($key == 'passwordHash') {
                            $password = $this->factory->createPassword();
                            $password->setPasswordHash($value);
                            $value = $password;
                        }
                        $jsonProperties = [
                          'authParams'
                        ];
                        $dateTimeProperties = [
                          'recentPasswordUpdateAt',
                          'updatedAt'
                        ];
                        if (in_array($key, $jsonProperties)) {
                            $value = json_decode($value);
                        }
                        if (in_array($key, $dateTimeProperties)) {
                            $value = DateTimeFormatter::createFromDb($value);
                        }
                        $entity->$setMethod($value);
                    }
                }
                return $entity;
            } else {
                return null;
            }
        } catch (\Exception $e) {
            throw new ServerErrorException('Failed Converting Data To User Identity Entity', false, $e->getMessage());
        }
    }
}
