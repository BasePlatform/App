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
      // Define for ResponseFactoryInterface
      \Base\Http\ResponseFactoryInterface::class => \Base\Http\ResponseFactory::class,

      // Define for ServiceRequestInterface
      \Base\ServiceRequest\ServiceRequestInterface::class => \Base\ServiceRequest\ServiceRequest::class,

      // Define for DbAdapterInterface
      \Base\Database\DbAdapterInter::class => \Base\Database\Adapter\MasterSlavePDO::class,

      // Define for Security Interface
      \Base\Security\SecurityInterface::class => \Base\Security\Security::class,

      // Define for Validator Interface
      \Base\Validator\ValidatorInterface::class => \Base\Validator\RespectValidator::class,

      // Define for LoggerInterface
      \Psr\Log\LoggerInterface::class => \Monolog\Logger::class
    ]
  ]
];
