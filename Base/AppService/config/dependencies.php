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
      \Base\AppService\Entity\AppInterface::class => \Base\AppService\Entity\App::class,

      \Base\AppService\Entity\ApUsagepInterface::class => \Base\AppService\Entity\AppUsage::class,

      /**
       * Factories
       */
      \Base\AppService\Factory\AppFactoryInterface::class => \Base\AppService\Factory\AppFactory::class,

      \Base\AppService\Factory\AppUsageFactoryInterface::class => \Base\AppService\Factory\AppUsageFactory::class,

      /**
       * Repositories
       */
      \Base\AppService\Repository\AppRepositoryInterface::class => \Base\AppService\Repository\AppRepository::class,

      \Base\AppService\Repository\AppUsageRepositoryInterface::class => \Base\AppService\Repository\AppUsageRepository::class,

      /**
       * Services
       */
      \Base\AppService\Service\AppUsageServiceInterface::class => \Base\AppService\Service\AppUsageService::class

    ],
    'params' => [
        /**
         * Factories
         */
        \Base\AppService\Factory\AppFactory::class => [
          'className' => \Base\AppService\Entity\App::class
        ],

        \Base\AppService\Factory\AppUsageFactory::class => [
          'className' => \Base\AppService\Entity\AppUsage::class
        ]

      ]
    ]
  ];
