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

use Fig\Http\Message\RequestMethodInterface as RequestMethod;

$pathPrefix = 'tenants';

return [
  'routes' => [
    [
      // Register a tenant to the system
      'path' => '/'.$pathPrefix.'/register',
      'name' => \Base\TenantService\Controller\Tenant\TenantController::class.':register',
      'handler' => \Base\TenantService\Controller\Tenant\TenantController::class.':register',
      'middlewares' => null,
      'allowedMethods' => [RequestMethod::METHOD_POST],
      'roles' => ['*']
    ]
  ]
];
