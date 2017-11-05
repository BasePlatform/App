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

declare(strict_types=1);

namespace Base\Middleware;

use Closure;
use Interop\Http\Server\MiddlewareInterface;
use Interop\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use InvalidArgumentException;
use LogicException;

/**
 * PSR-7 / PSR-15 middleware dispatcher interface
 *
 * @package Base\Middleware
 */
interface DispatcherInterface
{
    /**
    * Dispatch the request, return a response.
    *
    * This function will perform the following steps
    *
    * 1. Get the first remaining middleware in the
    * middlewares property of this class
    *
    * 2. Create a middleware instance based on the middleware information
    *
    * 3. Run the process() function of the newly created middleware
    *
    *
    * @param ServerRequestInterface $request
    *
    * @return ResponseInterface
    *
    * @throws LogicException on unexpected result from any middleware on the queue
    */
    public function dispatch(ServerRequestInterface $request): ResponseInterface;
}
