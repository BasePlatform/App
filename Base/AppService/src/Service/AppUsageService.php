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

namespace Base\AppService\Service;

use Base\AppService\Entity\AppUsageInterface;
use Base\AppService\Repository\AppRepositoryInterface;
use Base\AppService\Repository\AppUsageRepositoryInterface;
use Base\AppService\Factory\AppUsageFactoryInterface;
use Base\AppService\Exception\InvalidAppException;
use Base\AppService\Exception\DisabledAppUsageException;
use Base\Exception\ServerErrorException;
use Base\Helper\DateTimeHelper;

/**
 * App Usage Service
 *
 * @package Base\AppService\Service
 */
class AppUsageService implements AppUsageServiceInterface
{
    const STATUS_ACTIVATED = 'activated';

    /**
     * @var AppUsageRepositoryInterface
     */
    private $repository;

    /**
     * @var AppRepositoryInterface
     */
    private $appRepository;

    /**
     * @var AppUsageFactoryInterface
     */
    private $factory;

    /**
     * @param AppUsageRepositoryInterface $repository
     * @param AppRepositoryInterface $appRepository
     * @param AppUsageFactoryInterface $factory
     */
    public function __construct(
        AppUsageRepositoryInterface $repository,
        AppRepositoryInterface $appRepository,
        AppUsageFactoryInterface $factory
    ) {
        $this->repository = $repository;
        $this->appRepository = $appRepository;
        $this->factory = $factory;
    }

    /**
     * {@inheritdoc}
     */
    public function activate(array $data, int $trialDays): ?AppUsageInterface
    {
        // Get Info from $data
        $tenantId = $data['tenantId'] ?? null;
        $appId = $data['appId'] ?? null;

        // Validate the Data here

        // Get Info
        $app = $this->appRepository->find($appId);
        $appUsage = $this->repository->find($tenantId, $appId);

        // No App or App is disabled
        if (!$app || ($app && $app->getStatus() != $app->getStatusOptions('STATUS_ACTIVE'))) {
            throw new InvalidAppException();
        }

        // App is disabled for the Tenant
        if ($appUsage && ($appUsage->getStatus() != $appUsage->getStatusOptions('STATUS_ACTIVE'))) {
            throw new DisabledAppUsageException();
        }
        // Get current time
        $now = DateTimeHelper::now();
        // Prepare the result
        $result = null;
        // No AppUsage Record?
        if (!$appUsage) {
            // Insert a record of AppUsage
            $appUsage = $this->factory->create();
            $appUsage->setTenantId($tenantId);
            $appUsage->setAppId($appId);
            $appUsage->setStatus($appUsage->getStatusOptions('STATUS_ACTIVE'));
            $appUsage->setFirstInstallAt($now);
            $appUsage->setRecentInstallAt($now);
            $appUsage->setUpdatedAt($now);
            // Calculate the trial days
            if ($trialDays > 0) {
                $trialExpiresAt = clone $now;
                $trialExpiresAt->add(new \DateInterval('P'.$trialDays.'D'));
                $appUsage->setTrialExpiresAt($trialExpiresAt);
            } elseif ($trialDays == 0) {
                $appUsage->setTrialExpiresAt($now);
            }
            $appUsage = $this->repository->insert($appUsage);
        } else {
            // AppUsage existed, update the recentInstallAt
            $appUsage->setRecentInstallAt($now);
            $appUsage->setUpdatedAt($now);
            $result = $this->repository->update($appUsage);
        }
        if ($appUsage) {
            return $appUsage;
        }
        throw new ServerErrorException(sprintf('Failed Activating App `%s` For Tenant `%s`', $appId, $tenantId));
    }

    /**
     * {@inheritdoc}
     */
    public function validate(array $data, string $context = null)
    {
    }
}
