<?php
/*
 * This file is part of the BasePlatform project.
 *
 * (c) BasePlatform project <https://github.com/BasePlatform>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Base\Middleware;

use Closure;
use Interop\Http\Server\MiddlewareInterface;
use Interop\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use LogicException;

/**
 * Delegate Middleware for creating middleware from
 * Closure
 *
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
  public function process(ServerRequestInterface $request, RequestHandlerInterface $next): ResponseInterface
  {
      $response = call_user_func($this->handler, $request, $next);
      if (!($response instanceof ResponseInterface)) {
          throw new LogicException('The middleware must return a ResponseInterface');
      }
      return $response;
  }
}