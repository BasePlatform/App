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

namespace Base\TenantService\Controller;

use Interop\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Base\Http\ResponseFactoryInterface;
use Base\Rest\RestController;
use Base\TenantService\Service\TenantServiceInterface;

/**
 * This class provides the actions for Tenant in Public zone
 */
class TenantController extends RestController
{
  /**
   * @var TenantServiceInterface
   */
  private $tenantService;

  /**
   * @param TenantServiceInterface $response
   * @param ResponseFactoryInterface $response
   */
  public function __construct(TenantServiceInterface $tenantService, ResponseFactoryInterface $response)
  {
    $this->tenantService = $tenantService;
    parent::__construct($response);
  }

  /**
   * Processing the activities when a tenant registers to the system
   *
   * 1. Create Tenant Info
   * 2. Send Request to Auth Service to create the Tenant Owner User Info
   * 2. Send Request to App Service Activate the default App
   *
   *
   */
  public function register(ServerRequestInterface $request, RequestHandlerInterface $next): ResponseInterface
  {
    $id = $request->getAttribute(self::RESOURCE_ID);
    $body = $request->getParsedBody();
    return $this->responseFactory->createJson([
     'action' => 'register',
     'body' => $request->getParsedBody()
    ]);
  }
}
