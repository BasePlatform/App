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

namespace Base\AppService\Repository;

use Base\AppService\Entity\AppInterface;
use Base\AppService\Factory\AppFactoryInterface;
use Base\PDO\PDOProxyInterface;
use Base\Exception\ServerErrorException;
use Base\Formatter\DateTimeFormatter;

/**
 * App Repository
 *
 * @package Base\AppService\Repository
 */
class AppRepository implements AppRepositoryInterface
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
     * @var AppFactoryInterface
     */
    private $appFactory;

    /**
     * @param PDOProxyInterface $pdo
     * @param AppFactoryInterface $appFactory
     */
    public function __construct(PDOProxyInterface $pdo, AppFactoryInterface $appFactory)
    {
        $this->pdo = $pdo;
        $this->appFactory = $appFactory;
        if (defined('APP_SERVICE_CONSTANTS')
            && isset(APP_SERVICE_CONSTANTS['TABLE_PREFIX'])
            && !empty(APP_SERVICE_CONSTANTS['TABLE_PREFIX'])) {
            $this->tablePrefix = APP_SERVICE_CONSTANTS['TABLE_PREFIX'];
        }
    }

    /**
     * {@inheritdoc}
     */
    public function get(string $appId): ?AppInterface
    {
        try {
            $sql = 'SELECT * FROM '. $this->tablePrefix . 'App a WHERE a.id = :id LIMIT 0,1';
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute(['id' => $appId]);
            $result = $stmt->fetch();
            // Convert to the desired return type
            return $this->convertToEntity($result);
        } catch (\PDOException $e) {
            throw new ServerErrorException('Failed Getting App', false, $e->getMessage());
        }
    }

    /**
     * {@inheritdoc}
     */
    public function add(AppInterface $app): ?string
    {
        try {
            $this->pdo->beginTransaction();
            $sql = 'INSERT INTO ' . $this->tablePrefix . 'App (
                id,
                plans,
                params,
                status,
                updatedAt
              ) VALUES (
                :id,
                :plans,
                :params,
                :status,
                :updatedAt
              )';
            $stmt = $this->pdo->prepare($sql);
            $result = $stmt->execute([
              'id' => (string) $app->getId(),
              'plans' => ($app->getPlans() != null) ? json_encode($app->getPlans()) : null,
              'params' => ($app->getParams() != null) ? json_encode($app->getParams()) : null,
              'status' => (string) $app->getStatus(),
              'updatedAt' => DateTimeFormatter::toDb($app->getUpdatedAt())
            ]);
            $id = null;
            if ($result) {
                $id = $app->getId();
            }
            $this->pdo->commit();
            return $id;
        } catch (\PDOException $e) {
            $this->pdo->rollBack();
            throw new ServerErrorException('Failed Adding App to Storage', false, $e->getMessage());
        }
    }

    /**
     * {@inheritdoc}
     */
    public function convertToEntity($data): ?AppInterface
    {
        try {
            if (!empty($data)) {
                $app = $this->appFactory->createNew();
                foreach ($data as $key => $value) {
                    $setMethod = 'set'.ucfirst($key);
                    if (method_exists($app, $setMethod)) {
                        $dateTimeProperties = [
                          'updatedAt'
                        ];
                        if (in_array($key, $dateTimeProperties)) {
                            $value = DateTimeFormatter::createFromDb($value);
                        }
                        $app->$setMethod($value);
                    }
                }
                return $app;
            } else {
                return null;
            }
        } catch (\Exception $e) {
            throw new ServerErrorException(
                'Failed Converting Data To App Entity',
                false,
                $e->getMessage()
            );
        }
    }
}
