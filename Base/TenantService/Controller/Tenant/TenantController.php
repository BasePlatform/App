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

namespace Base\TenantService\Controller\Tenant;

use Interop\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Base\Http\ResponseFactoryInterface;
use Base\Rest\RestController;

/**
 * This class provides the actions for Tenant in Public section
 */
class TenantController extends RestController
{
  /**
   * Register a tenant to the system
   * and Activate the default App
   *
   */
  public function register(ServerRequestInterface $request, RequestHandlerInterface $next)
  {
    $id = $request->getAttribute(self::RESOURCE_ID);
    return $this->responseFactory->createJson([
     'action' => 'register'
    ]);
  }
}
