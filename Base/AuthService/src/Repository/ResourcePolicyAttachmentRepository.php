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

use Base\AuthService\Entity\ResourcePolicyAttachmentInterface;
use Base\AuthService\Factory\ResourcePolicyAttachmentFactoryInterface;
use Base\PDO\PDOProxyInterface;
use Base\Exception\ServerErrorException;
use Base\Helper\DateTimeHelper;

/**
 * Resource Policy Attachment Repository
 *
 * @package Base\AuthService\Repository
 */
class ResourcePolicyAttachmentRepository implements ResourcePolicyAttachmentRepository
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
     * @var ResourcePolicyAttachmentInterface
     */
    private $factory;

    /**
     * @param PDOProxyInterface $pdo
     * @param ResourcePolicyAttachmentFactoryInterface $factory
     */
    public function __construct(PDOProxyInterface $pdo, ResourcePolicyAttachmentFactoryInterface $factory)
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
    public function findAll(string $tenantId, string $resourceId): ?array
    {
        try {
            $sql = 'SELECT * FROM '. $this->tablePrefix . 'ResourcePolicyAttachment rpa WHERE
                rpa.tenantId = :tenantId AND
                rpa.resourceId = :resourceId';
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
              'tenantId' => $tenantId,
              'resourceId' => $resourceId
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
            throw new ServerErrorException(sprintf('Failed Finding Policies of Resource `%s` Of Tenant `%s`', $resourceId, $tenantId), false, $e->getMessage());
        }
    }

    /**
     * {@inheritdoc}
     */
    public function insert(ResourcePolicyAttachmentInterface $item): ?ResourcePolicyAttachmentInterface
    {
        try {
            $this->pdo->beginTransaction();
            $sql = 'INSERT INTO ' . $this->tablePrefix . 'ResourcePolicyAttachment (
                tenantId,
                resourceId,
                policyId,
                attachedAt
              ) VALUES (
                :tenantId,
                :resourceId,
                :policyId,
                :attachedAt
              )';
            $stmt = $this->pdo->prepare($sql);
            $result = $stmt->execute([
              'tenantId' => $item->getTenantId(),
              'resourceId' => $item->getResourceId(),
              'policyId' => $item->getPolicyId(),
              'attachedAt' => DateTimeHelper::toDb($item->getAttachedAt())
            ]);
            if ($result) {
                $this->pdo->commit();
                $id = (int) $this->pdo->lastInsertId();
                $item->setId($id);
                return $item;
            } else {
                $this->pdo->rollBack();
                return null;
            }
        } catch (\PDOException $e) {
            $this->pdo->rollBack();
            throw new ServerErrorException('Failed Attaching Resource Policy', false, $e->getMessage());
        }
    }

    /**
     * {@inheritdoc}
     */
    public function delete(string $tenantId, string $resourceId, string $policyId): bool
    {
        try {
            $this->pdo->beginTransaction();
            $sql = 'DELETE FROM ' . $this->tablePrefix . 'ResourcePolicyAttachment rpa WHERE
                rpa.tenantId = :tenantId AND
                rpa.resourceId = :resourceId AND
                rpa.policyId = :policyId
              LIMIT 1';
            $stmt = $this->pdo->prepare($sql);
            $result = $stmt->execute([
              'tenantId' => $tenantId,
              'resourceId' => $resourceId,
              'policyId' => $policyId
            ]);
            $this->pdo->commit();
            return $result;
        } catch (\PDOException $e) {
            $this->pdo->rollBack();
            throw new ServerErrorException(sprintf('Failed Deleting Policy `%s` Attachment Of Resource `%s` Of Tenant `%s`', $resourceId, $tenantId), false, $e->getMessage());
        }
    }

    /**
     * {@inheritdoc}
     */
    public function deleteAll(string $tenantId, string $resourceId): bool
    {
        try {
            $this->pdo->beginTransaction();
            $sql = 'DELETE FROM ' . $this->tablePrefix . 'ResourcePolicyAttachment rpa WHERE
                rpa.tenantId = :tenantId AND
                rpa.resourceId = :resourceId';
            $stmt = $this->pdo->prepare($sql);
            $result = $stmt->execute([
              'tenantId' => $tenantId,
              'resourceId' => $resourceId
            ]);
            $this->pdo->commit();
            return $result;
        } catch (\PDOException $e) {
            $this->pdo->rollBack();
            throw new ServerErrorException(sprintf('Failed Deleting All Policy Attachments Of Resource `%s` Of Tenant `%s`', $resourceId, $tenantId), false, $e->getMessage());
        }
    }

    /**
     * {@inheritdoc}
     */
    public function convertToEntity($data): ?ResourcePolicyAttachmentInterface
    {
        try {
            if (!empty($data)) {
                $entity = $this->factory->create();
                foreach ($data as $key => $value) {
                    $setMethod = 'set'.ucfirst($key);
                    if (method_exists($entity, $setMethod) && $value != null) {
                        $dateTimeProperties = [
                          'attachedAt'
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
            throw new ServerErrorException('Failed Converting Data To Resource Policy Attachment Entity', false, $e->getMessage());
        }
    }
}
