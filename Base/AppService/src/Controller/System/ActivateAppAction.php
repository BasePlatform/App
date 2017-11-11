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
    const STATUS_ACTIVATED = 'activated';

    /**
     * @var AppUsageServiceInterface
     */
    private $appUsageService;

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
     * @param AppUsageServiceInterface $response
     * @param array $appConfig
     */
    public function __construct(ResponseFactoryInterface $responseFactory, AppUsageServiceInterface $appUsageService, array$appConfig)
    {
        $this->responseFactory = $responseFactory;
        $this->appUsageService = $appUsageService;
        $this->appConfig = $appConfig;
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
        $result = $this->appUsageService->activate($data, $this->appConfig);
        if ($result) {
            return $this->responseFactory->createJson([
              'status' => self::STATUS_ACTIVATED
            ]);
        } else {
            throw new ServerErrorException(sprintf('Failed Activating App `%s` For Tenant `%s`', $appId, $tenantId));
        }
    }
}
