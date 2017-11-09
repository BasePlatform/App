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
use Base\Formatter\DateTimeFormatter;

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
    private $appFactory;

    /**
     * @param PDOProxyInterface $pdo
     * @param AppUsageFactoryInterface $appFactory
     */
    public function __construct(PDOProxyInterface $pdo, AppUsageFactoryInterface $appFactory)
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
    public function get(string $tenantId, string $appId): ?AppUsageInterface
    {
        try {
            $sql = 'SELECT * FROM '. $this->tablePrefix . 'AppUsage au WHERE au.tenantId = :tenantI AND au.appId = :appId
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
            throw new ServerErrorException('Failed Getting App Usage', false, $e->getMessage());
        }
    }

    /**
     * {@inheritdoc}
     */
    public function add(AppUsageInterface $appUsage): ?integer
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
              'tenantId' => (string) $appUsage->getTenantId(),
              'appId' => (string) $appUsage->getAppId(),
              'selectedPlan' => (string) $appUsage->getSelectedPlan(),
              'appParams' => ($appUsage->getAppParams() != null) ? json_encode($appUsage->getAppParams()) : null,
              'externalInfo' => ($appUsage->getExternalInfo() != null) ? json_encode($appUsage->getExternalInfo()) : null,
              'chargeInfo' => ($appUsage->getChargeInfo() != null) ? json_encode($appUsage->getChargeInfo()) : null,
              'exceededPlanUsage' => (bool) $appUsage->getExceededPlanUsage(),
              'exceededPlanAt' => DateTimeFormatter::toDb($appUsage->getExceededPlanAt()),
              'planUpgradeRequired' => (bool) $appUsage->getPlanUpgradeRequired(),
              'firstInstallAt' => DateTimeFormatter::toDb($appUsage->getFirstInstallAt()),
              'recentInstallAt' => DateTimeFormatter::toDb($appUsage->getRecentInstallAt()),
              'recentUninstallAt' => DateTimeFormatter::toDb($appUsage->getRecentUninstallAt()),
              'trialExpiresAt' => DateTimeFormatter::toDb($appUsage->getTrialExpiresAt()),
              'status' => (string) $appUsage->getStatus(),
              'updatedAt' => DateTimeFormatter::toDb($appUsage->getUpdatedAt())
            ]);
            $id = null;
            if ($result) {
                $id = $app->getId();
            }
            $this->pdo->commit();
            return $id;
        } catch (\PDOException $e) {
            $this->pdo->rollBack();
            throw new ServerErrorException('Failed Adding App Usage to Storage', false, $e->getMessage());
        }
    }

    /**
     * {@inheritdoc}
     */
    public function update(AppUsageInterface $appUsage): bool
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
              WHERE au.id = :id LIMIT 1
              )';
            $stmt = $this->pdo->prepare($sql);
            $result = $stmt->execute([
              'id' => (int) $appUsage->getId(),
              'tenantId' => (string) $appUsage->getTenantId(),
              'appId' => (string) $appUsage->getAppId(),
              'selectedPlan' => (string) $appUsage->getSelectedPlan(),
              'appParams' => ($appUsage->getAppParams() != null) ? json_encode($appUsage->getAppParams()) : null,
              'externalInfo' => ($appUsage->getExternalInfo() != null) ? json_encode($appUsage->getExternalInfo()) : null,
              'chargeInfo' => ($appUsage->getChargeInfo() != null) ? json_encode($appUsage->getChargeInfo()) : null,
              'exceededPlanUsage' => (bool) $appUsage->getExceededPlanUsage(),
              'exceededPlanAt' => DateTimeFormatter::toDb($appUsage->getExceededPlanAt()),
              'planUpgradeRequired' => (bool) $appUsage->getPlanUpgradeRequired(),
              'firstInstallAt' => DateTimeFormatter::toDb($appUsage->getFirstInstallAt()),
              'recentInstallAt' => DateTimeFormatter::toDb($appUsage->getRecentInstallAt()),
              'recentUninstallAt' => DateTimeFormatter::toDb($appUsage->getRecentUninstallAt()),
              'trialExpiresAt' => DateTimeFormatter::toDb($appUsage->getTrialExpiresAt()),
              'status' => (string) $appUsage->getStatus(),
              'updatedAt' => DateTimeFormatter::toDb($appUsage->getUpdatedAt())
            ]);
            $this->pdo->commit();
            return $result;
        } catch (\PDOException $e) {
            $this->pdo->rollBack();
            throw new ServerErrorException('Failed Updating App Usage to Storage', false, $e->getMessage());
        }
    }

    /**
     * {@inheritdoc}
     */
    public function convertToEntity($data): ?AppInterface
    {
        try {
            if (!empty($data)) {
                $app = $this->appFactory->create();
                foreach ($data as $key => $value) {
                    $setMethod = 'set'.ucfirst($key);
                    if (method_exists($app, $setMethod)) {
                        $dateTimeProperties = [
                          'exceededPlanAt',
                          'firstInstallAt',
                          'recentInstallAt',
                          'recentUninstallAt',
                          'trialExpiresAt',
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
            throw new ServerErrorException('Failed Converting Data To App Usage Entity', false, $e->getMessage());
        }
    }
}
