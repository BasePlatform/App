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

return [
  'dependencies' => [
    'definitions' => [
      /**
       * Entities and Value Objects
       */
      \Base\AuthService\Entity\PolicyInterface::class => \Base\AuthService\Entity\Policy::class,

      \Base\AuthService\Entity\ResourcePolicyAttachmentInterface::class => \Base\AuthService\Entity\ResourcePolicyAttachment::class,

      \Base\AuthService\Entity\UserInterface::class => \Base\AuthService\Entity\User::class,

      \Base\AuthService\Entity\UserIdentityInterface::class => \Base\AuthService\Entity\UserIdentity::class,

      \Base\AuthService\Entity\UserProfileInterface::class => \Base\AuthService\Entity\UserProfile::class,

      \Base\AuthService\ValueObject\ZoneInterface::class => \Base\AuthService\ValueObject\Zone::class,

      \Base\AuthService\ValueObject\PasswordInterface::class => \Base\AuthService\ValueObject\Password::class,

      /**
       * Factories
       */
      \Base\AuthService\Factory\PolicyFactoryInterface::class => \Base\AuthService\Factory\PolicyFactory::class,

      \Base\AuthService\Factory\ResourcePolicyAttachmentFactoryInterface::class => \Base\AuthService\Factory\ResourcePolicyAttachmentFactory::class,

      \Base\AuthService\Factory\UserFactoryInterface::class => \Base\AuthService\Factory\UserFactory::class,

      \Base\AuthService\Factory\UserIdentityFactoryInterface::class => \Base\AuthService\Factory\UserIdentityFactory::class,

      \Base\AuthService\Factory\UserProfileFactoryInterface::class => \Base\AuthService\Factory\UserProfileFactory::class,

      \Base\AuthService\Factory\ZoneFactoryInterface::class => \Base\AuthService\Factory\ZoneFactory::class,

      \Base\AuthService\Factory\PasswordFactoryInterface::class => \Base\AuthService\Factory\PasswordFactory::class,

      /**
       * Repositories
       */
      \Base\AuthService\Repository\PolicyRepositoryInterface::class => \Base\AuthService\Repository\PolicyRepository::class,

      \Base\AuthService\Repository\ResourcePolicyAttachmentRepositoryInterface::class => \Base\AuthService\Repository\ResourcePolicyAttachmentRepository::class,

      \Base\AuthService\Repository\UserRepositoryInterface::class => \Base\AuthService\Repository\UserRepository::class,

      \Base\AuthService\Repository\UserIdentityRepositoryInterface::class => \Base\AuthService\Repository\UserIdentityRepository::class,

      \Base\AuthService\Repository\UserProfileRepositoryInterface::class => \Base\AuthService\Repository\UserProfileRepository::class,

      /**
       * Services
       */
      \Base\AuthService\Service\UserServiceInterface::class => \Base\AuthService\Service\UserService::class,

    ],
    'params' => [
        /**
         * Factories
         */
        \Base\AuthService\Factory\PolicyFactory::class => [
          'className' => \Base\AuthService\Entity\Policy::class
        ],

        \Base\AuthService\Factory\ResourcePolicyAttachmentFactory::class => [
          'className' => \Base\AuthService\Entity\ResourcePolicyAttachment::class
        ],

        \Base\AuthService\Factory\UserFactory::class => [
          'className' => \Base\AuthService\Entity\User::class
        ],

        \Base\AuthService\Factory\UserIdentityFactory::class => [
          'className' => \Base\AuthService\Entity\UserIdentity::class
        ],

        \Base\AuthService\Factory\UserProfileFactory::class => [
          'className' => \Base\AuthService\Entity\UserProfile::class
        ],

        \Base\AuthService\Factory\ZoneFactory::class => [
          'className' => Base\AuthService\ValueObject\Zone::class
        ],

        \Base\AuthService\Factory\PasswordFactory::class => [
          'className' => \Base\AuthService\ValueObject\Password::class
        ],
      ]
    ]
  ];
