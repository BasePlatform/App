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

namespace Base\TenantService\Controller\Site;

use Interop\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Base\Http\ResponseFactoryInterface;
use Base\TenantService\Service\TenantServiceInterface;
use Base\Rest\RestAction;

/**
 * Register a Tenant to the App
 *
 * @package Base\TenantService\Controller\Site
 */
class RegisterTenantAction extends RestAction
{
    /**
     * @var TenantServiceInterface
     */
    private $tenantService;

    /**
     * @var array
     */
    private $appConfig;

    /**
     * @var ResponseFactoryInterface
     */
    public $responseFactory;

    /**
     * @param ResponseFactoryInterface $responseFactory
     * @param TenantServiceInterface $response
     * @param array $appConfig
     */
    public function __construct(ResponseFactoryInterface $responseFactory, TenantServiceInterface $tenantService, array$appConfig)
    {
        $this->responseFactory = $responseFactory;
        $this->tenantService = $tenantService;
        $this->appConfig = $appConfig;
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
    public function process(ServerRequestInterface $request, RequestHandlerInterface $next): ResponseInterface
    {
        $data = $request->getParsedBody();
        return $this->responseFactory->createJson($this->tenantService->register($data, $this->appConfig));
    }
}
