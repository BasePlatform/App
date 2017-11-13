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

namespace Base\AuthService\Controller\System;

use Interop\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Base\Http\ResponseFactoryInterface;
use Base\AuthService\Service\UserServiceInterface;
use Base\Rest\RestAction;
use Base\Exception\ServerErrorException;

/**
 * Register Tenant Owner
 *
 * @package Base\AppService\Controller\System
 */
class RegisterTenantOwnerAction extends RestAction
{
    /**
     * @var UserServiceInterface
     */
    private $userService;

    /**
     * @var ResponseFactoryInterface
     */
    public $responseFactory;

    /**
     * @param ResponseFactoryInterface $responseFactory
     * @param UserServiceInterface $response
     */
    public function __construct(ResponseFactoryInterface $responseFactory, UserServiceInterface $userService)
    {
        $this->responseFactory = $responseFactory;
        $this->userService = $userService;
    }

    /**
     * Register Tenant Owner
     *
     * @param ServerRequestInterface $request
     * @param RequestHandlerInterface $next
     *
     * @return ResponseInterface
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $next): ResponseInterface
    {
        $data = $request->getParsedBody();
        return $this->responseFactory->createJson($this->userService->registerTenantOwner($data));
    }
}
