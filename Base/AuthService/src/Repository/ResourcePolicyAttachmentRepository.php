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

use Base\AuthServivce\Entity\ResourcePolicyAttachmentInterface;
use Base\AuthService\Factory\ResourcePolicyAttachmentFactoryInterface;
use Base\PDO\PDOProxyInterface;
use Base\Exception\ServerErrorException;
use Base\Formatter\DateTimeFormatter;

/**
 * Resource Policy Attachment Repository
 *
 * @package Base\AuthServivce\Repository
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
    public function findAll(string $tenantId, string $resourceId)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function add(ResourcePolicyAttachmentInterface $item)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function delete(string $tenantId, string $resourceId, string $policyId)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function deleteAll(string $tenantId, string $resourceId)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function convertToEntity($data)
    {
        try {
            if (!empty($data)) {
                $entity = $this->factory->create();
                foreach ($data as $key => $value) {
                    $setMethod = 'set'.ucfirst($key);
                    if (method_exists($entity, $setMethod)) {
                        $dateTimeProperties = [
                          'attachedAt'
                        ];
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
            throw new ServerErrorException('Failed Converting Data To Resource Policy Attachment Entity', false, $e->getMessage());
        }
    }
}
