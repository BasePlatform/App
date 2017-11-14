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
use Base\Security\SecurityInterface;
use Base\Exception\ServerErrorException;
use Base\Helper\DateTimeHelper;

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
     * @var SecurityInterface
     */
    private $security;

    /**
     * @param UserRepositoryInterface $repository
     * @param UserIdentityRepositoryInterface $userIdentityRepository
     * @param UserProfileRepositoryInterface $userProfileRepository
     * @param UserFactoryInterface $factory
     * @param UserIdentityFactoryInterface $userIdentityFactory
     * @param UserProfileFactoryInterface $userProfileFactory
     * @param ZoneFactoryInterface $zoneFactory
     * @param SecurityInterface $security
     */
    public function __construct(
        UserRepositoryInterface $repository,
        UserIdentityRepositoryInterface $userIdentityRepository,
        UserProfileRepositoryInterface $userProfileRepository,
        UserFactoryInterface $factory,
        UserIdentityFactoryInterface $userIdentityFactory,
        UserProfileFactoryInterface $userProfileFactory,
        ZoneFactoryInterface $zoneFactory,
        SecurityInterface $security
    ) {
        $this->repository = $repository;
        $this->userIdentityRepository = $userIdentityRepository;
        $this->userProfileRepository = $userProfileRepository;
        $this->factory = $factory;
        $this->userIdentityFactory = $userIdentityFactory;
        $this->userProfileFactory = $userProfileFactory;
        $this->zoneFactory = $zoneFactory;
        $this->security = $security;
    }

    /**
     * {@inheritdoc}
     */
    public function registerTenantOwner(array $data)
    {
        // Get Info from $data
        $tenantId = $data['tenantId'] ?? null;
        $email = $data['email'] ?? null;
        $password = $data['password'] ?? null;
        $authProvider = $data['authProvider'] ?? null;
        $authProviderUid = $data['authProviderUid'] ?? null;

        // Validate the Data here

        $zone = call_user_func([$this->zoneFactory->getClassName(), 'createZone']);
        $zoneAdminId = $zone->getZoneOptions('ZONE_ADMIN');
        $zone->setZoneId($zoneAdminId);

        // Adding the User
        $now = DateTimeHelper::now();
        $user = $this->factory->create();
        $user->setTenantId($tenantId);
        $user->setZone($zone);
        $user->setEmail($email);
        $user->setUserName($email);
        $user->setStatus($user->getStatusOptions('STATUS_ACTIVE'));
        $user->setCreatedAt($now);
        $user->setUpdatedAt($now);
        $user = $this->repository->insert($user);

        if ($user) {
            // continue adding user identity and profile
            $userIdentity = $this->userIdentityFactory->create();
            if (empty($password)) {
                $password = $this->security->generateRandomKey(8);
            }
            $authToken = $this->security->generateRandomString(32);
            $userIdentity->setTenantId($tenantId);
            $userIdentity->setUserId($user->getId());
            $userIdentity->setAuthProvider($authProvider);
            $userIdentity->setAuthProviderUid($authProviderUid);
            $userIdentity->setAuthToken($authToken);
            $userIdentity->setPasswordHash($this->security->generatePasswordHash($password));
            $userIdentity->setRecentPasswordUpdateAt($now);
            $userIdentity->setUpdatedAt($now);
            // Save the Identity
            $userIdentity = $this->userIdentityRepository->insert($userIdentity);

            $userProfile = $this->userProfileFactory->create();
            $userProfile->setTenantId($tenantId);
            $userProfile->setUserId($user->getId());
            $userProfile->setUpdatedAt($now);
            // Save the Profile
            $userProfile = $this->userProfileRepository->insert($userProfile);

            if ($userIdentity && $userProfile) {
                $user->setIdentity($userIdentity);
                $user->setProfile($userProfile);
                return $user;
            }
        }

        throw new ServerErrorException(sprintf('Failed Registering Owner For Tenant `%s`', $tenantId));
    }

    /**
     * {@inheritdoc}
     */
    public function validate(array $data, string $context = null)
    {
    }
}
