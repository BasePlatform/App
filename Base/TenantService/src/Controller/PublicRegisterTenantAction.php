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

use Interop\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Base\Http\ResponseFactoryInterface;

/**
 * Register a Tenant to the App
 *
 * @package Base\TenantService\Controller
 */
class PublicRegisterTenantAction extends MiddlewareInterface
{
    /**
     * @var ResponseFactoryInterface
     */
    public $responseFactory;

    /**
     * @var TenantMapperInterface
     */
    private $dataMapper;

    /**
     * @var TenantFactoryInterface
     */
    private $factory;

    /**
     * @var ValidatorInterface
     */
    private $validator;

    /**
     * @var RegisterTenantOwnerRequest
     */
    private $registerTenantOwnerRequest;

    /**
     * @param ResponseFactoryInterface     $responseFactory
     * @param RegisterTenantCommandHandler $commandHandler
     */
    public function __construct(
        ResponseFactoryInterface $responseFactory,
        RegisterTenantCommandHandler $commandHandler
    ) {
        $this->responseFactory = $responseFactory;
        $this->commandHandler = $commandHandler;
    }

     /**
     * {@inheritdoc}
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $next): ResponseInterface
    {
        $data = $request->getParsedBody();
        $config = \Base\Service::$config;
        $command = new RegisterTenantCommand(
            $data,
            $config->get('app.defaultInstallAppId'),
            $config->get('app.domain'),
            $config->get('app.platform')
        );
        return $this->responseFactory->createJson($this->commandHandler->handle($command));
    }
}
