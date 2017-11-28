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

$appPathPrefix = 'apps';
$authPathPrefix = 'auth';

return [
  'requiredEndpoints' => [
    'APP_SERVICE' => [
      'app.system.activateAppEndpoint' => [
        'path' => 'system/'.$appPathPrefix.'/activate',
        'method' => RequestMethod::METHOD_POST,
        'options' => []
      ]
    ],
    'AUTH_SERVICE' => [
      'auth.system.registerTenantOwnerEndpoint' => [
        'path' => 'system/'.$authPathPrefix.'/users/register-tenant-owner',
        'method' => RequestMethod::METHOD_POST,
        'options' => []
      ]
    ],
  ]
];
