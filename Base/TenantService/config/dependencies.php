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
    'aliases' => [
      /**
       * Entities and Value Objects
       */
      \Base\TenantService\Entity\TenantInterface::class => \Base\TenantService\Entity\Tenant::class,

      \Base\TenantService\ValueObject\TenantIdInterface::class => \Base\TenantService\ValueObject\TenantId::class,

      /**
       * Factories
       */
      \Base\TenantService\Factory\TenantFactoryInterface::class => \Base\TenantService\Factory\TenantFactory::class,

      /**
       * Repositories
       */
      \Base\TenantService\Repository\TenantRepositoryInterface::class => \Base\TenantService\Repository\TenantRepository::class,

      /**
       * Services
       */
      \Base\TenantService\Service\TenantServiceInterface::class => \Base\TenantService\Service\TenantService::class
    ],
    'params' => [
      /**
       * Factories
       */
      \Base\TenantService\Factory\TenantFactory::class => [
        ':factory' => new \Base\Factory\Factory(Base\TenantService\Entity\Tenant::class),
        ':tenantIdFactory' => new \Base\Factory\Factory(Base\TenantService\ValueObject\TenantId::class)
      ],
      /**
       * Controllers and Actions
       */
      \Base\TenantService\Controller\Site\RegisterTenantAction::class => function () use ($config) {
          return [':appConfig' => $config->get('app')];
      }
    ]
  ]
];
