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

use Base\AuthService\Entity\UserProfileInterface;
use Base\AuthService\Factory\UserProfileFactoryInterface;
use Base\PDO\PDOProxyInterface;
use Base\Exception\ServerErrorException;
use Base\Formatter\DateTimeFormatter;

/**
 * User Profile Repository
 *
 * @package Base\AuthService\Repository
 */
class UserProfileRepository implements UserProfileRepositoryInterface
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
     * @var UserProfileFactoryInterface
     */
    private $factory;

    /**
     * @param PDOProxyInterface $pdo
     * @param UserProfileFactoryInterface $factory
     */
    public function __construct(PDOProxyInterface $pdo, UserProfileFactoryInterface $factory)
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
    public function find(string $tenantId, int $userId): ?UserProfileInterface
    {
        try {
            $sql = 'SELECT * FROM '. $this->tablePrefix . 'UserProfile up WHERE
                up.tenantId = :tenantId AND
                up.userId = :userId
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
            throw new ServerErrorException(sprintf('Failed Finding User Profile `%s` Of Tenant `%s`', (string) $userId, $tenantId), false, $e->getMessage());
        }
    }

    /**
     * {@inheritdoc}
     */
    public function add(UserProfileInterface $item): ?int
    {
        try {
            $this->pdo->beginTransaction();
            $sql = 'INSERT INTO ' . $this->tablePrefix . 'UserProfile (
                tenantId,
                userId,
                gender,
                birthDate,
                firstName,
                lastName,
                location,
                company,
                info,
                updatedAt
              ) VALUES (
                :tenantId,
                :userId,
                :gender,
                :birthDate,
                :firstName,
                :lastName,
                :location,
                :company,
                :info,
                :updatedAt
              )';
            $stmt = $this->pdo->prepare($sql);
            $result = $stmt->execute([
              'tenantId' => $item->getTenantId(),
              'userId' => (int) $item->getUserId(),
              'gender' => $item->getGender(),
              'birthDate' => ($item->getBirthDate() != null) ?$item->getBirthDate->format(DateTimeFormatter::DB_DATE_FORMAT) : null,
              'firstName' => $item->getFirstName(),
              'lastName' => $item->getLastName(),
              'location' => $item->getLocation(),
              'company' => $item->getCompany(),
              'info' => ($item->getInfo() != null) ? json_encode($item->getInfo()) : null,
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
            throw new ServerErrorException('Failed Adding User Profile Information', false, $e->getMessage());
        }
    }

    /**
     * {@inheritdoc}
     */
    public function update(UserProfileInterface $item): bool
    {
        try {
            $this->pdo->beginTransaction();
            $sql = 'UPDATE ' . $this->tablePrefix . 'UserProfile up SET
                tenantId = :tenantId,
                userId = :userId,
                gender = :gender,
                birthDate = :birthDate,
                firstName = :firstName,
                lastName = :lastName,
                location = :location,
                company = :company,
                info = :info,
                updatedAt = :updatedAt
              WHERE ui.id = :id LIMIT 1';
            $stmt = $this->pdo->prepare($sql);
            $result = $stmt->execute([
              'id' => (int) $item->getId(),
              'tenantId' => $item->getTenantId(),
              'userId' => (int) $item->getUserId(),
              'gender' => $item->getGender(),
              'birthDate' => ($item->getBirthDate() != null) ?$item->getBirthDate->format(DateTimeFormatter::DB_DATE_FORMAT) : null,
              'firstName' => $item->getFirstName(),
              'lastName' => $item->getLastName(),
              'location' => $item->getLocation(),
              'company' => $item->getCompany(),
              'info' => ($item->getInfo() != null) ? json_encode($item->getInfo()) : null,
              'updatedAt' => DateTimeFormatter::toDb($item->getUpdatedAt())
            ]);
            $this->pdo->commit();
            return $result;
        } catch (\PDOException $e) {
            $this->pdo->rollBack();
            throw new ServerErrorException('Failed Updating User Profile Information', false, $e->getMessage());
        }
    }

    /**
     * {@inheritdoc}
     */
    public function convertToEntity($data): ?UserProfileInterface
    {
        try {
            if (!empty($data)) {
                $entity = $this->factory->create();
                foreach ($data as $key => $value) {
                    $setMethod = 'set'.ucfirst($key);
                    if (method_exists($entity, $setMethod) && $value != null) {
                        if ($key == 'birthDate' && $value) {
                            $value = \DateTime::creatFromFormat(DateTimeFormatter::DB_DATE_FORMAT, $value);
                        }
                        $jsonProperties = [
                          'info'
                        ];
                        $dateTimeProperties = [
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
            throw new ServerErrorException('Failed Converting Data To User Profile Entity', false, $e->getMessage());
        }
    }
}
