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

$pathPrefix = 'apps';

return [
  'routes' => [
    [
      // System - Activate The App
      'name' => 'app.system.activateAppEndpoint',
      'path' => '/system/'.$pathPrefix.'/activate',
      'handler' => \Base\AppService\Controller\System\ActivateAppAction::class,
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
