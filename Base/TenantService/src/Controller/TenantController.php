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

/**
 * This class provides the actions for Tenant in Public Zone
 *
 * @package Base\TenantService\Controller
 */
class TenantController
{
    /**
     * @var TenantServiceInterface
     */
    private $tenantService;

    /**
     * @var string
     */
    private $domain;

    /**
     * @var string
     */
    private $platform;

    /**
     * @var ResponseFactoryInterface
     */
    public $responseFactory;

    /**
     * @param ResponseFactoryInterface $responseFactory
     * @param TenantServiceInterface $response
     * @param string $domain
     * @param string $platform
     */
    public function __construct(ResponseFactoryInterface $responseFactory, TenantServiceInterface $tenantService, string $domain, string $platform)
    {
        $this->tenantService = $tenantService;
        $this->domain = $domain;
        $this->platform = $platform;
        $this->responseFactory = $responseFactory;
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
    public function registerAction(ServerRequestInterface $request, RequestHandlerInterface $next): ResponseInterface
    {
        $data = $request->getParsedBody();
        return $this->responseFactory->createJson($this->tenantService->register($data, $this->domain, $this->platform));
    }
}
