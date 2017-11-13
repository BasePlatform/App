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

namespace Base\AuthService\Service;

use Base\AuthService\Repository\UserRepositoryInterface;
use Base\AuthService\Repository\UserIdentityRepositoryInterface;
use Base\AuthService\Repository\UserProfileRepositoryInterface;
use Base\AuthService\Factory\UserFactoryInterface;
use Base\AuthService\Factory\UserIdentityFactoryInterface;
use Base\AuthService\Factory\UserProfileFactoryInterface;
use Base\AuthService\Factory\ZoneFactoryInterface;
use Base\Exception\ServerErrorException;
use Base\Formatter\DateTimeFormatter;

/**
 * User Service
 *
 * @package Base\AuthService\Service
 */
class UserService implements UserServiceInterface
{
    /**
     * @var UserRepositoryInterface
     */
    private $repository;

    /**
     * @var UserIdentityRepositoryInterface
     */
    private $userIdentityRepository;

    /**
     * @var UserProfileRepositoryInterface
     */
    private $userProfileRepository;

    /**
     * @var UserFactoryInterface
     */
    private $factory;

    /**
     * @var UserIdentityFactoryInterface
     */
    private $userIdentityFactory;

    /**
     * @var UserProfileFactoryInterface
     */
    private $userProfileFactory;

    /**
     * @var ZoneFactoryInterface
     */
    private $zoneFactory;

    /**
     * @param UserRepositoryInterface $repository
     * @param UserIdentityRepositoryInterface $userIdentityRepository
     * @param UserProfileRepositoryInterface $userProfileRepository
     * @param UserFactoryInterface $factory
     * @param UserIdentityFactoryInterface $userIdentityFactory
     * @param UserProfileFactoryInterface $userProfileFactory
     * @param ZoneFactoryInterface $zoneFactory
     */
    public function __construct(
        UserRepositoryInterface $repository,
        UserIdentityRepositoryInterface $userIdentityRepository,
        UserProfileRepositoryInterface $userProfileRepository,
        UserFactoryInterface $factory,
        UserIdentityFactoryInterface $userIdentityFactory,
        UserProfileFactoryInterface $userProfileFactory,
        ZoneFactoryInterface $zoneFactory
    ) {
        $this->repository = $repository;
        $this->userIdentityRepository = $userIdentityRepository;
        $this->userProfileRepository = $userProfileRepository;
        $this->factory = $factory;
        $this->userIdentityFactory = $userIdentityFactory;
        $this->userProfileFactory = $userProfileFactory;
        $this->zoneFactory = $zoneFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function registerTenantOwner(array $data): array
    {
        // Get Info from $data
        $tenantId = $data['tenantId'] ?? null;
        $email = $data['email'] ?? null;
        $password = $data['password'] ?? null;

        // Validate the Data here

        $zone = call_user_func([$this->zoneFactory->getClassName(), 'createZone']);
        $zoneAdminId = $zone->getZoneOptions('ZONE_ADMIN');
        $zone->setZoneId($zoneAdminId);

        // Adding the User
        $now = DateTimeFormatter::now();
        $user = $this->factory->create();
        $user->setTenantId($tenantId);
        $user->setZone($zone);
        $user->setEmail($email);
        $user->setUserName($email);
        $user->setStatus($user->getStatusOptions('STATUS_ACTIVE'));
        $user->setCreatedAt($now);
        $user->setUpdatedAt($now);
        $userId = $this->repository->add($user);

        if ($userId) {
            // continue adding user identity and profile
            $userIdentity = $this->userIdentityFactory->create();
            $userIdentity->setTenantId($tenantId);
            $userIdentity->setUserId($userId);

            $userProfile = $this->userProfileFactory->create();
        }
        exit;
        $app = $this->appRepository->get($appId);
        $appUsage = $this->repository->get($tenantId, $appId);

        // No App or App is disabled
        if (!$app || ($app && $app->getStatus() != $app->getStatusOptions('STATUS_ACTIVE'))) {
            throw new InvalidAppException();
        }

        // App is disabled for the Tenant
        if ($appUsage && ($appUsage->getStatus() != $appUsage->getStatusOptions('STATUS_ACTIVE'))) {
            throw new DisabledAppUsageException();
        }
        // Get current time
        $now = DateTimeFormatter::now();
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
            $result = $this->repository->add($appUsage);
        } else {
            // AppUsage existed, update the recentInstallAt
            $appUsage->setRecentInstallAt($now);
            $appUsage->setUpdatedAt($now);
            $result = $this->repository->update($appUsage);
        }
        if ($result) {
            return [
              'appId' => $appId,
              'tenantId' => $tenantId,
              'status' => self::STATUS_ACTIVATED
            ];
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
