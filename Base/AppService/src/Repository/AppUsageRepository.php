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

use Base\AppService\Entity\AppUsageInterface;
use Base\AppService\Factory\AppUsageFactoryInterface;
use Base\PDO\PDOProxyInterface;
use Base\Exception\ServerErrorException;
use Base\Helper\DateTimeHelper;

/**
 * App Usage Repository
 *
 * @package Base\AppService\Repository
 */
class AppUsageRepository implements AppUsageRepositoryInterface
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
     * @var AppUsageFactoryInterface
     */
    private $factory;

    /**
     * @param PDOProxyInterface $pdo
     * @param AppUsageFactoryInterface $factory
     */
    public function __construct(PDOProxyInterface $pdo, AppUsageFactoryInterface $factory)
    {
        $this->pdo = $pdo;
        $this->factory = $factory;
        if (defined('APP_SERVICE_CONSTANTS')
            && isset(APP_SERVICE_CONSTANTS['TABLE_PREFIX'])
            && !empty(APP_SERVICE_CONSTANTS['TABLE_PREFIX'])) {
            $this->tablePrefix = APP_SERVICE_CONSTANTS['TABLE_PREFIX'];
        }
    }

    /**
     * {@inheritdoc}
     */
    public function find(string $tenantId, string $appId): ?AppUsageInterface
    {
        try {
            $sql = 'SELECT * FROM '. $this->tablePrefix . 'AppUsage au WHERE
                au.tenantId = :tenantId AND
                au.appId = :appId
              LIMIT 0,1';
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
              'tenantId' => $tenantId,
              'appId' => $appId,
            ]);
            $result = $stmt->fetch();
            // Convert to the desired return type
            return $this->convertToEntity($result);
        } catch (\PDOException $e) {
            throw new ServerErrorException(sprintf('Failed Getting App `%s` Usage Info Of Tenant `%s`', $appId, $tenantId), false, $e->getMessage());
        }
    }

    /**
     * {@inheritdoc}
     */
    public function insert(AppUsageInterface $item): ?AppUsageInterface
    {
        try {
            $this->pdo->beginTransaction();
            $sql = 'INSERT INTO ' . $this->tablePrefix . 'AppUsage (
                tenantId,
                appId,
                selectedPlan,
                appParams,
                externalInfo,
                chargeInfo,
                exceededPlanUsage,
                exceededPlanAt,
                planUpgradeRequired,
                firstInstallAt,
                recentInstallAt,
                recentUninstallAt,
                trialExpiresAt,
                status,
                updatedAt
              ) VALUES (
                :tenantId,
                :appId,
                :selectedPlan,
                :appParams,
                :externalInfo,
                :chargeInfo,
                :exceededPlanUsage,
                :exceededPlanAt,
                :planUpgradeRequired,
                :firstInstallAt,
                :recentInstallAt,
                :recentUninstallAt,
                :trialExpiresAt,
                :status,
                :updatedAt
              )';
            $stmt = $this->pdo->prepare($sql);
            $result = $stmt->execute([
              'tenantId' => $item->getTenantId(),
              'appId' => $item->getAppId(),
              'selectedPlan' => $item->getSelectedPlan(),
              'appParams' => ($item->getAppParams() != null) ? json_encode($item->getAppParams()) : null,
              'externalInfo' => ($item->getExternalInfo() != null) ? json_encode($item->getExternalInfo()) : null,
              'chargeInfo' => ($item->getChargeInfo() != null) ? json_encode($item->getChargeInfo()) : null,
              'exceededPlanUsage' => (int) $item->getExceededPlanUsage(),
              'exceededPlanAt' => DateTimeHelper::toDb($item->getExceededPlanAt()),
              'planUpgradeRequired' => (int) $item->getPlanUpgradeRequired(),
              'firstInstallAt' => DateTimeHelper::toDb($item->getFirstInstallAt()),
              'recentInstallAt' => DateTimeHelper::toDb($item->getRecentInstallAt()),
              'recentUninstallAt' => DateTimeHelper::toDb($item->getRecentUninstallAt()),
              'trialExpiresAt' => DateTimeHelper::toDb($item->getTrialExpiresAt()),
              'status' => $item->getStatus(),
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
            throw new ServerErrorException('Failed Adding App Usage Information', false, $e->getMessage());
        }
    }

    /**
     * {@inheritdoc}
     */
    public function update(AppUsageInterface $item): ?AppUsageInterface
    {
        try {
            $this->pdo->beginTransaction();
            $sql = 'UPDATE ' . $this->tablePrefix . 'AppUsage au SET
                tenantId = :tenantId,
                appId = :appId,
                selectedPlan = :selectedPlan,
                appParams = :appParams,
                externalInfo = :externalInfo,
                chargeInfo = :chargeInfo,
                exceededPlanUsage = :exceededPlanUsage,
                exceededPlanAt = :exceededPlanAt,
                planUpgradeRequired = :planUpgradeRequired,
                firstInstallAt = :firstInstallAt,
                recentInstallAt = :recentInstallAt,
                recentUninstallAt = :recentUninstallAt,
                trialExpiresAt = :trialExpiresAt,
                status = :status,
                updatedAt = :updatedAt
              WHERE au.id = :id LIMIT 1';
            $stmt = $this->pdo->prepare($sql);
            $result = $stmt->execute([
              'id' => (int) $item->getId(),
              'tenantId' => $item->getTenantId(),
              'appId' => $item->getAppId(),
              'selectedPlan' => $item->getSelectedPlan(),
              'appParams' => ($item->getAppParams() != null) ? json_encode($item->getAppParams()) : null,
              'externalInfo' => ($item->getExternalInfo() != null) ? json_encode($item->getExternalInfo()) : null,
              'chargeInfo' => ($item->getChargeInfo() != null) ? json_encode($item->getChargeInfo()) : null,
              'exceededPlanUsage' => (int) $item->getExceededPlanUsage(),
              'exceededPlanAt' => DateTimeHelper::toDb($item->getExceededPlanAt()),
              'planUpgradeRequired' => (int) $item->getPlanUpgradeRequired(),
              'firstInstallAt' => DateTimeHelper::toDb($item->getFirstInstallAt()),
              'recentInstallAt' => DateTimeHelper::toDb($item->getRecentInstallAt()),
              'recentUninstallAt' => DateTimeHelper::toDb($item->getRecentUninstallAt()),
              'trialExpiresAt' => DateTimeHelper::toDb($item->getTrialExpiresAt()),
              'status' => $item->getStatus(),
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
            throw new ServerErrorException('Failed Updating App Usage Information', false, $e->getMessage());
        }
    }

    /**
     * {@inheritdoc}
     */
    public function convertToEntity($data): ?AppUsageInterface
    {
        try {
            if (!empty($data)) {
                $entity = $this->factory->create();
                foreach ($data as $key => $value) {
                    $setMethod = 'set'.ucfirst($key);
                    if (method_exists($entity, $setMethod) && $value != null) {
                        $jsonProperties = [
                          'appParams',
                          'externalInfo',
                          'chargeInfo',
                        ];
                        $dateTimeProperties = [
                          'exceededPlanAt',
                          'firstInstallAt',
                          'recentInstallAt',
                          'recentUninstallAt',
                          'trialExpiresAt',
                          'updatedAt'
                        ];
                        if (in_array($key, $jsonProperties)) {
                            $value = json_decode($value);
                        }
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
            throw new ServerErrorException('Failed Converting Data To App Usage Entity', false, $e->getMessage());
        }
    }
}
