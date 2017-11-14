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
use Base\AuthService\ValueObject\ZoneInterface;
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
    public function find(string $policyId): ?PolicyInterface
    {
        try {
            $sql = 'SELECT * FROM '. $this->tablePrefix . 'Policy p WHERE p.id = :id LIMIT 0,1';
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute(['id' => $policyId]);
            $result = $stmt->fetch();
            // Convert to the desired return type
            return $this->convertToEntity($result);
        } catch (\PDOException $e) {
            throw new ServerErrorException(sprintf('Failed Getting Policy `%s`', $policyId), false, $e->getMessage());
        }
    }

    /**
     * {@inheritdoc}
     */
    public function findAllByAppTypeZone(string $appId, string $type, ZoneInterface $zone): ?array
    {
        try {
            $sql = 'SELECT * FROM '. $this->tablePrefix . 'Policy p WHERE
                p.appId = :appId AND
                p.type = :type AND
                p.zone = :zone';
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
              'appId' => $appId,
              'type' => $type,
              'zone' => (string) $zone,
            ]);
            $results = $stmt->fetchAll();
            if ($results && !empty($results)) {
                $entities = [];
                foreach ($results as $result) {
                    $entities[] = $this->convertToEntity($result);
                }
                return $entities;
            } else {
                return null;
            }
        } catch (\PDOException $e) {
            throw new ServerErrorException(sprintf('Failed Finding Policies Of App `%s` With Type `%s` In Zone `%s`', $appId, $type, (string) $zone), false, $e->getMessage());
        }
    }

    /**
     * {@inheritdoc}
     */
    public function insert(PolicyInterface $item): ?PolicyInterface
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
              'id' => $item->getId(),
              'appId' => $item->getAppId(),
              'type' => $item->getType(),
              'zone' => (string) $item->getZone(),
              'description' => $item->getDescription(),
              'params' => ($item->getParams() != null) ? json_encode($item->getParams()) : null
            ]);
            if ($result) {
                $this->pdo->commit();
                return $item;
            } else {
                $this->pdo->rollBack();
                return $null;
            }
        } catch (\PDOException $e) {
            $this->pdo->rollBack();
            throw new ServerErrorException('Failed Adding Policy Information', false, $e->getMessage());
        }
    }

    /**
     * {@inheritdoc}
     */
    public function delete(string $policyId): bool
    {
        try {
            $this->pdo->beginTransaction();
            $sql = 'DELETE FROM ' . $this->tablePrefix . 'Policy p WHERE p.id = :id';
            $stmt = $this->pdo->prepare($sql);
            $result = $stmt->execute([
              'id' => $policyId,
            ]);
            $this->pdo->commit();
            return $result;
        } catch (\PDOException $e) {
            $this->pdo->rollBack();
            throw new ServerErrorException(sprintf('Failed Deleting Policy `%s`', $policyId), false, $e->getMessage());
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
                    if (method_exists($entity, $setMethod) && $value != null) {
                        if ($key == 'zone') {
                            $zone = $this->zoneFactory->create();
                            $zone->setZoneId($value);
                            $value = $zone;
                        }
                        $jsonProperties = [
                          'params'
                        ];
                        if (in_array($key, $jsonProperties)) {
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
