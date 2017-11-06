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
 * This class provides the actions for Tenant in Public Zone
 *
 * @package Base\TenantService\Controller
 */
class TenantController extends RestController
{
    /**
     * @var TenantServiceInterface
     */
    private $tenantService;


    /**
     * @param TenantServiceInterface $response
     * @param string $domain
     * @param ResponseFactoryInterface $response
     */
    public function __construct(TenantServiceInterface $tenantService, ResponseFactoryInterface $responseFactory)
    {
        $this->tenantService = $tenantService;
        parent::__construct($responseFactory);
    }

    /**
     * Activate the app
     *
     * @param ServerRequestInterface $request
     * @param RequestHandlerInterface $next
     *
     * @return ResponseInterface
     */
    public function activateAction(ServerRequestInterface $request, RequestHandlerInterface $next): ResponseInterface
    {
        $data = $request->getParsedBody();
        return $this->responseFactory->createJson($data);
    }
}
