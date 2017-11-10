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

use Base\AuthService\Entity\PolicyInterface;
use Base\AuthService\Entity\ZoneInterface;
use Base\AuthService\Factory\PolicyFactoryInterface;
use Base\AuthService\Factory\ZoneFactoryInterface;
use Base\PDO\PDOProxyInterface;
use Base\Exception\ServerErrorException;

/**
 * Policy Repository
 *
 * @package Base\AuthService\Repository
 */
class PolicyRepository implements PolicyRepositoryInterface
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
     * @var PolicyFactoryInterface
     */
    private $factory;

    /**
     * @var ZoneFactoryInterface
     */
    private $zoneFactory;

    /**
     * @param PDOProxyInterface $pdo
     * @param PolicyFactoryInterface $factory
     * @param ZoneFactoryInterface $zoneFactory
     */
    public function __construct(PDOProxyInterface $pdo, PolicyFactoryInterface $factory, ZoneFactoryInterface $zoneFactory)
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
    public function get(string $policyId): ?PolicyInterface
    {
        try {
            $sql = 'SELECT * FROM '. $this->tablePrefix . 'Policy p WHERE p.id = :id LIMIT 0,1';
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute(['id' => $policyId]);
            $result = $stmt->fetch();
            // Convert to the desired return type
            return $this->convertToEntity($result);
        } catch (\PDOException $e) {
            throw new ServerErrorException('Failed Getting Policy', false, $e->getMessage());
        }
    }

    /**
     * {@inheritdoc}
     */
    public function findAllByAppTypeZone(string $appId, string $type, ZoneInterface $zone)
    {
        try {
            $sql = 'SELECT * FROM '. $this->tablePrefix . 'Policy p
            WHERE p.appId = :appId AND
                    p.type = :type AND
                    p.zone = :zone';
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
              'appId' => $appId,
              'type' => $type,
              'zone' => (string) $zone,
            ]);
            $result = $stmt->fetch();
            // Convert to the desired return type
            return $this->convertToEntity($result);
        } catch (\PDOException $e) {
            throw new ServerErrorException('Failed Finding Policies', false, $e->getMessage());
        }
    }

    /**
     * {@inheritdoc}
     */
    public function add(PolicyInterface $item): ?string
    {
        try {
            $this->pdo->beginTransaction();
            $sql = 'INSERT INTO ' . $this->tablePrefix . 'Policy (
                id,
                appId,
                type,
                zone,
                description,
                params
              ) VALUES (
                :id,
                :appId,
                :type,
                :zone,
                :description,
                :params
              )';
            $stmt = $this->pdo->prepare($sql);
            $result = $stmt->execute([
              'id' => (string) $item->getId(),
              'appId' => (string) $item->getAppId(),
              'type' => (string) $item->getType(),
              'zone' => (string) $item->getZone(),
              'description' => (string) $item->getDescription(),
              'params' => ($item->getParams() != null) ? json_encode($item->getParams()) : null
            ]);
            $id = null;
            if ($result) {
                $id = $item->getId();
            }
            $this->pdo->commit();
            return $id;
        } catch (\PDOException $e) {
            $this->pdo->rollBack();
            throw new ServerErrorException('Failed Adding Policy', false, $e->getMessage());
        }
    }

    /**
     * {@inheritdoc}
     */
    public function delete(string $policyId): bool
    {
        try {
            $this->pdo->beginTransaction();
            $sql = 'DELETE FROM ' . $this->tablePrefix . 'Policy p
            WHERE p.id = :id';
            $stmt = $this->pdo->prepare($sql);
            $result = $stmt->execute([
              'id' => $policyId,
            ]);
            $this->pdo->commit();
            return $result;
        } catch (\PDOException $e) {
            $this->pdo->rollBack();
            throw new ServerErrorException('Failed Deleting Policy', false, $e->getMessage());
        }
    }

    /**
     * {@inheritdoc}
     */
    public function convertToEntity($data): ?PolicyInterface
    {
        try {
            if (!empty($data)) {
                $entity = $this->factory->create();
                foreach ($data as $key => $value) {
                    $setMethod = 'set'.ucfirst($key);
                    if ($key == 'zone') {
                        $zone = $this->zoneFactory->create();
                        $zone->setZoneId($value);
                        $value = $zone;
                    }
                    if (method_exists($entity, $setMethod)) {
                        $jsonProperties = [
                          'params'
                        ];
                        if (in_array($key, $dateTimeProperties)) {
                            $value = json_decode($value);
                        }
                        $entity->$setMethod($value);
                    }
                }
                return $entity;
            } else {
                return null;
            }
        } catch (\Exception $e) {
            throw new ServerErrorException('Failed Converting Data To Policy Entity', false, $e->getMessage());
        }
    }
}
