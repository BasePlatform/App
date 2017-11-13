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
      // Site - Register a tenant to the system
      'name' => 'tenant.site.registerTenantEndpoint',
      'path' => '/'.$pathPrefix.'/register',
      'handler' => \Base\TenantService\Controller\Site\RegisterTenantAction::class,
      'middlewares' => null,
      'allowedMethods' => [RequestMethod::METHOD_POST],
      'allowedPolicies' => '*',
      'enabled' => true
    ]
  ]
];
