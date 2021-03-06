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
use Base\AuthService\Repository\ResourcePolicyAttachmentRepositoryInterface;
use Base\AuthService\Factory\UserFactoryInterface;
use Base\AuthService\Factory\UserIdentityFactoryInterface;
use Base\AuthService\Factory\UserProfileFactoryInterface;
use Base\AuthService\Factory\ResourcePolicyAttachmentFactoryInterface;
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
     * @var ResourcePolicyAttachmentRepositoryInterface
     */
    private $resourcePolicyAttachmentRepository;

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
     * @var ResourcePolicyAttachmentFactory
     */
    private $resourcePolicyAttacmentFactory;

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
     * @param ResourcePolicyAttachmentRepositoryInterface $resourcePolicyAttachmentRepository
     * @param UserFactoryInterface $factory
     * @param UserIdentityFactoryInterface $userIdentityFactory
     * @param UserProfileFactoryInterface $userProfileFactory
     * @param ResourcePolicyAttachmentFactoryInterface $resourcePolicyAttacmentFactory
     * @param ZoneFactoryInterface $zoneFactory
     * @param SecurityInterface $security
     */
    public function __construct(
        UserRepositoryInterface $repository,
        UserIdentityRepositoryInterface $userIdentityRepository,
        UserProfileRepositoryInterface $userProfileRepository,
        ResourcePolicyAttachmentRepositoryInterface $resourcePolicyAttachmentRepository,
        UserFactoryInterface $factory,
        UserIdentityFactoryInterface $userIdentityFactory,
        UserProfileFactoryInterface $userProfileFactory,
        ResourcePolicyAttachmentFactoryInterface $resourcePolicyAttacmentFactory,
        ZoneFactoryInterface $zoneFactory,
        SecurityInterface $security
    ) {
        $this->repository = $repository;
        $this->userIdentityRepository = $userIdentityRepository;
        $this->userProfileRepository = $userProfileRepository;
        $this->resourcePolicyAttachmentRepository = $resourcePolicyAttachmentRepository;
        $this->factory = $factory;
        $this->userIdentityFactory = $userIdentityFactory;
        $this->userProfileFactory = $userProfileFactory;
        $this->resourcePolicyAttacmentFactory = $resourcePolicyAttacmentFactory;
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

        // Create Zone
        $zoneAdminId = $zone->getZoneOptions('ZONE_ADMIN');
        $zone = call_user_func_array([$this->zoneFactory->getClassName(), 'createFromString'], [$zoneAdminId]);

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

            // Attach the tenant.tenantOwner policy
            $attachedPolicy = $this->resourcePolicyAttacmentFactory->create();
            $attachedPolicy->setTenantId($tenantId);
            $resourceId = call_user_func_array([$this->resourcePolicyAttacmentFactory->getClassName(), 'createResourceId'], ['user', $user->getId()]);
            $attachedPolicy->setResourceId($resourceId);
            $attachedPolicy->setPolicyId('tenant.tenantOwner');
            $attachedPolicy->setAttachedAt($now);
            // Save attached Policy
            $attachedPolicy = $this->resourcePolicyAttachmentRepository->insert($attachedPolicy);

            if ($userIdentity && $userProfile && $attachedPolicy) {
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
