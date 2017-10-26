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

use Interop\Http\Server\MiddlewareInterface;
use Interop\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use FastRoute\Dispatcher;
use Base\Exception\NotFoundException;
use Base\Exception\MethodNotAllowedException;

/**
 * FastRoute middleware based on FastRoute package
 *
 * @package Base\Middleware
 */
class FastRouteMiddleware implements MiddlewareInterface
{
  const HANDLER_ATTRIBUTE = 'request-handler';

  /**
   * @var Dispatcher $dispatcher
   */
  private $routeDispatcher;

  /**
   * @param Dispatcher $dispatcher
   *
   * @param mixed $container
   */
  public function __construct(Dispatcher $routeDispatcher)
  {
    $this->routeDispatcher = $routeDispatcher;
  }

  /**
   * {@inheritdoc}
   */
  public function process(ServerRequestInterface $request, RequestHandlerInterface $next): ResponseInterface
  {
    $routeInfo = $this->routeDispatcher->dispatch($request->getMethod(), $request->getUri()->getPath());

    // Not Found, return immediately a 404 Not Found Response
    if ($routeInfo[0] === Dispatcher::NOT_FOUND) {
      throw new NotFoundException();
    }

    // Method not allowed, return immediately a 405 Not Found Response
    if ($routeInfo[0] === Dispatcher::METHOD_NOT_ALLOWED) {
      throw new MethodNotAllowedException();
    }

    // Passed all, let process the request

    // Add params to Request attributes
    foreach ($routeInfo[2] as $name => $value) {
      $request = $request->withAttribute($name, $value);
    }

    // We set an attribute called request-handler with the value based on the defined callable handler
    // Then it is assigned to the next middlewares
    // At the RequestHandlerMiddleware, it will check this attribute
    // to get a callable handler to process the request
    $request = $request->withAttribute(self::HANDLER_ATTRIBUTE, $routeInfo[1]);

    // We now set all necessary request information
    // Send it to next middleware to handle it
    return $next->handle($request);
  }
}
