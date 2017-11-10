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

namespace Base\AuthServivce\Repository;

use Base\AuthServivce\Entity\UserIdentityInterface;
use Base\AuthServivce\Factory\UserIdentityFactoryInterface;
use Base\PDO\PDOProxyInterface;
use Base\Exception\ServerErrorException;
use Base\Formatter\DateTimeFormatter;

/**
 * User Identity Repository
 *
 * @package Base\AuthServivce\Repository
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
            throw new ServerErrorException('Failed Finding User Identity', false, $e->getMessage());
        }
    }

    /**
     * {@inheritdoc}
     */
    public function add(UserIdentityInterface $item): ?integer
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
                accountActivateToken,
                accountActivateExpiresAt,
                passwordResetToken,
                passwordResetExpiresAt,
                recentPasswordUpdateAt,
                recentLoginAt,
                updatedAt,
              ) VALUES (
                :tenantId,
                :userId,
                :authProvider,
                :authProviderUid,
                :passwordHash,
                :authParams,
                :accountActivateToken,
                :accountActivateExpiresAt,
                :passwordResetToken,
                :passwordResetExpiresAt,
                :recentPasswordUpdateAt,
                :recentLoginAt,
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
              'accountActivateToken' => $item->getAccountActivateToken(),
              'accountActivateExpiresAt' => DateTimeFormatter::toDb($item->getAccountActivateExpiresAt()),
              'passwordResetToken' => $item->getPasswordResetToken(),
              'passwordResetExpiresAt' => DateTimeFormatter::toDb($item->getPasswordResetExpiresAt()),
              'recentPasswordUpdateAt' => DateTimeFormatter::toDb($item->getRecentPasswordUpdateAt()),
              'recentLoginAt' => DateTimeFormatter::toDb($item->getRecentLoginAt()),
              'updatedAt' => DateTimeFormatter::toDb($item->getUpdatedAt())
            ]);
            $id = null;
            if ($result) {
                $id = $this->pdo->lastInsertId();
            }
            $this->pdo->commit();
            return $id;
        } catch (\PDOException $e) {
            $this->pdo->rollBack();
            throw new ServerErrorException('Failed Adding User Identity', false, $e->getMessage());
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
                accountActivateToken = :accountActivateToken,
                accountActivateExpiresAt = :accountActivateExpiresAt,
                passwordResetToken = :passwordResetToken,
                passwordResetExpiresAt = :passwordResetExpiresAt,
                recentPasswordUpdateAt = :recentPasswordUpdateAt,
                recentLoginAt = :recentLoginAt,
                updatedAt = :updatedAt
              WHERE ui.id = :id LIMIT 1
              )';
            $stmt = $this->pdo->prepare($sql);
            $result = $stmt->execute([
              'id' => (int) $item->getId(),
              'tenantId' => $item->getTenantId(),
              'userId' => (int) $item->getUserId(),
              'authProvider' => $item->getAuthProvider(),
              'authProviderUid' => $item->getAuthProviderUid(),
              'passwordHash' => ($item->getPasswordHash() != null) ? (string) $item->getPasswordHash() : null,
              'authParams' => ($item->getAuthParams() != null) ? json_encode($item->getAuthParams()) : null,
              'accountActivateToken' => $item->getAccountActivateToken(),
              'accountActivateExpiresAt' => DateTimeFormatter::toDb($item->getAccountActivateExpiresAt()),
              'passwordResetToken' => $item->getPasswordResetToken(),
              'passwordResetExpiresAt' => DateTimeFormatter::toDb($item->getPasswordResetExpiresAt()),
              'recentPasswordUpdateAt' => DateTimeFormatter::toDb($item->getRecentPasswordUpdateAt()),
              'recentLoginAt' => DateTimeFormatter::toDb($item->getRecentLoginAt()),
              'updatedAt' => DateTimeFormatter::toDb($item->getUpdatedAt())
            ]);
            $this->pdo->commit();
            return $result;
        } catch (\PDOException $e) {
            $this->pdo->rollBack();
            throw new ServerErrorException('Failed Updating User Identity', false, $e->getMessage());
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
                    if ($key == 'passwordHash') {
                        $password = $this->factory->createPassword();
                        $password->setPasswordHash($value);
                        $value = $password;
                    }
                    if (method_exists($entity, $setMethod)) {
                        $jsonProperties = [
                          'authParams'
                        ];
                        $dateTimeProperties = [
                          'accountActivateExpiresAt',
                          'passwordResetExpiresAt',
                          'recentPasswordUpdateAt',
                          'recentLoginAt',
                          'updatedAt'
                        ];
                        if (in_array($key, $jsonProperties) && $value) {
                            $value = json_decode($value);
                        }
                        if (in_array($key, $dateTimeProperties) && $value) {
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
