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

$pathPrefix = 'auth';

return [
  'routes' => [
    [
      // System - Register Tenant Owner
      'name' => 'auth.system.registerTenantOwnerEndpoint',
      'path' => '/system/'.$pathPrefix.'/users/register-tenant-owner',
      'handler' => \Base\AuthService\Controller\System\RegisterTenantOwnerAction::class,
      'middlewares' => null,
      'allowedMethods' => [RequestMethod::METHOD_POST],
      'allowedPolicies' => [
        'app.internalServiceRequest',
        'app.systemAdmin'
      ],
      'enabled' => true
    ]
  ]
];
