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

namespace Base\TenantService\Application\Controller;

use Interop\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Base\Http\ResponseFactoryInterface;
use Base\TenantService\Application\Command\RegisterTenantCommand;
use Base\TenantService\Application\Command\RegisterTenantCommandHandler;

/**
 * Register a Tenant to the App
 *
 * @package Base\TenantService\Application\Controller
 */
class PublicRegisterTenantAction extends MiddlewareInterface
{
    /**
     * @var ResponseFactoryInterface
     */
    public $responseFactory;

    /**
     * @param ResponseFactoryInterface $responseFactory
     */
    public function __construct(ResponseFactoryInterface $responseFactory)
    {
        $this->responseFactory = $responseFactory;
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
        $commandHandler = new RegisterTenantCommandHandler();
        return $this->responseFactory->createJson($commandHandler->handle($command));
    }
}
