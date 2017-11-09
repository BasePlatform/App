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

namespace Base\AppService\Controller;

use Interop\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Base\Http\ResponseFactoryInterface;

/**
 * This class provides the actions for App in System Zone
 *
 * @package Base\AppService\Controller
 */
class AppSystemController
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
