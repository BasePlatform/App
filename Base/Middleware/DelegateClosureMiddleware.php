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
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Delegate Middleware for creating middleware from Closure
 *
 * @package Base\Middleware
 */
class DelegateClosureMiddleware implements MiddlewareInterface
{
  /**
   * @param Closure $handler
   */
    public function __construct(Closure $handler)
    {
        $this->handler = $handler;
    }

  /**
   * {@inheritdoc}
   */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        return call_user_func($this->handler, $request, $handler);
    }
}
