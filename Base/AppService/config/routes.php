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
      // System - Activate the app
      'path' => 'system/'.$pathPrefix.'/activate',
      'name' => \Base\AppService\Controller\Tenant\AppSystemController::class.':activate',
      'handler' => \Base\AppService\Controller\Tenant\AppSystemController::class.':activate',
      'middlewares' => null,
      'allowedMethods' => [RequestMethod::METHOD_POST],
      'roles' => ['internal_request', 'system_admin']
    ]
  ]
];
