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
       * Models
       */
      \Base\TenantService\Model\TenantInterface::class => \Base\TenantService\Model\Tenant::class,
      \Base\TenantService\Model\TenantIdInterface::class => \Base\TenantService\Model\TenantId::class,
      \Base\TenantService\Model\TenantStatusInterface::class => \Base\TenantService\Model\TenantStatus::class,
      \Base\TenantService\Model\TenantFactoryInterface::class => \Base\TenantService\Model\TenantFactory::class,
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
      \Base\TenantService\Model\Factory\TenantFactory::class => [
        'class' => \Base\TenantService\Model\Tenant::class,
        'tenantCollectionClass' => \Base\TenantService\Model\TenantCollection::class,
        'tenantIdClass' => \Base\TenantService\Model\TenantId::class,
        'tenantStatusClass' => \Base\TenantService\Model\TenantStatus::class,
      ]
    ]
  ]
];
