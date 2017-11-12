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

namespace Base\AppService\Controller\System;

use Interop\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Base\Http\ResponseFactoryInterface;
use Base\AppService\Service\AppUsageServiceInterface;
use Base\Rest\RestAction;
use Base\Exception\ServerErrorException;

/**
 * Activate App
 *
 * @package Base\AppService\Controller\System
 */
class ActivateAppAction extends RestAction
{
    /**
     * @var AppUsageServiceInterface
     */
    private $appUsageService;

    /**
     * @var ResponseFactoryInterface
     */
    public $responseFactory;

    /**
     * @param ResponseFactoryInterface $responseFactory
     * @param AppUsageServiceInterface $response
     */
    public function __construct(ResponseFactoryInterface $responseFactory, AppUsageServiceInterface $appUsageService)
    {
        $this->responseFactory = $responseFactory;
        $this->appUsageService = $appUsageService;
    }

    /**
     * Activate the app
     *
     * @param ServerRequestInterface $request
     * @param RequestHandlerInterface $next
     *
     * @return ResponseInterface
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $next): ResponseInterface
    {
        $data = $request->getParsedBody();
        $trialDays = \Base\Base::$config->get('app.trialDays');
        return $this->responseFactory->createJson($this->appUsageService->activate($data, $trialDays));
    }
}
