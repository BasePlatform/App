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
use Base\TenantService\Service\TenantServiceInterface;
use Base\Rest\RestController;

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
   * @var string
   */
    private $serviceDomain;

  /**
   * @var string
   */
    private $platform = null;

  /**
   * @param TenantServiceInterface $response
   * @param string $serviceDomain
   * @param ResponseFactoryInterface $response
   */
    public function __construct(
        TenantServiceInterface $tenantService,
        string $serviceDomain,
        string $platform,
        ResponseFactoryInterface $responseFactory
    ) {
        $this->tenantService = $tenantService;
        $this->serviceDomain = $serviceDomain;
        $this->platform = $platform;
        parent::__construct($responseFactory);
    }

  /**
   * Processing the activities when a tenant registers to the system
   *
   * 1. Create Tenant Info
   * 2. Send Request to Auth Service to create the Tenant Owner User Info
   * 2. Send Request to App Service Activate the default App
   *
   * @param ServerRequestInterface $request
   * @param RequestHandlerInterface $next
   *
   * @return ResponseInterface
   */
    public function register(ServerRequestInterface $request, RequestHandlerInterface $next): ResponseInterface
    {
        $data = $request->getParsedBody();
        return $this->responseFactory->createJson($this->tenantService->register($data, $this->serviceDomain, $this->platform));
    }
}
