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
use Base\Http\ResponseFactoryInterface;
use Base\Rest\RestController;

/**
 * This class provides the actions for Tenant in Admin zone
 */
class TenantAdminController extends RestController
{
    public function getSettings(ServerRequestInterface $request, RequestHandlerInterface $next): ResponseInterface
    {
        return $this->responseFactory->createJson([
        'action' => 'getSettings'
        ]);
    }

    public function updateSettings(ServerRequestInterface $request, RequestHandlerInterface $next): ResponseInterface
    {
        return $this->responseFactory->createJson([
        'action' => 'updateSettings'
        ]);
    }
}
