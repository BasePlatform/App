<?php
/*
 * This file is part of the BasePlatform project.
 *
 * (c) BasePlatform project <https://github.com/BasePlatform>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Base\TenantService\Controller\Tenant;

use Interop\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Base\Http\ResponseFactoryInterface;
use Base\Rest\RestController;

/**
 * This class provides the actions for Tenant in Admin section
 *
 * @author Tuan Nguyen <nganhtuan63@gmail.com>
 */
class TenantAdminController extends RestController
{

  public function getSettings(ServerRequestInterface $request, RequestHandlerInterface $next) {
    return $this->responseFactory->createJson([
      'action' => 'getSettings'
    ]);
  }

  public function updateSettings(ServerRequestInterface $request, RequestHandlerInterface $next) {
    return $this->responseFactory->createJson([
      'action' => 'updateSettings'
    ]);
  }
}
