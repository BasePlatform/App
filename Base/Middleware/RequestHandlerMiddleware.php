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
use ReflectionClass;
use ReflectionMethod;
use InvalidArgumentException;
use RuntimeException;

/**
 * Request Handler middleware that handle the request routed by a Route Middleware and return a Response
 *
 * Small tweak to support the Auryn container
 *
 * Modify to support a MiddlewareInterface object as a callabe handler
 *
 * Based on the work of https://github.com/middlewares/request-handler
 *
 * @package Base\Middleware
 */
class RequestHandlerMiddleware implements MiddlewareInterface
{
    const HANDLER_ATTRIBUTE = 'request-handler';

  /**
   * @var mixed
   */
    private $container;

  /**
   * @var array Extra arguments passed to the handler
   */
    private $args = [];

  /**
   * Extra arguments passed to the handler.
   *
   * @return self
   */
    public function args(...$args)
    {
        $this->args = $args;
        return $this;
    }

  /**
   * @param mixed $container
   */
    public function __construct($container = null)
    {
        $this->container = $container;
    }

  /**
   * {@inheritdoc}
   */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $next): ResponseInterface
    {
      // The request now has all the information
      // parsed by previous RouteMiddleware
        $handler = $request->getAttribute(self::HANDLER_ATTRIBUTE);

        $args = array_merge([$request, $next], $this->args);

        if (is_string($handler)) {
          // Check to support the format Class:method
          // E.g: /App/Controller/HomeController:index
          // Use : like the format of Slim
            if (strpos($handler, ':') !== false) {
                list($id, $method) = explode(':', $handler, 2);
                $handler = [$id, $method];
            }
        }

      // This $handler must be a callable
      // Forward to the next middleware if having
      // Consider this or disable this?
        if ($this->container) {
            if (is_string($handler)) {
                $handler = $this->createClassFromContainer($handler);
            } elseif (is_array($handler) && is_string($handler[0])) {
                list($class, $method) = $handler;
                $class = $this->createClassFromContainer($handler[0]);
                $handler = [$class, $method];
            }
            if (is_callable($handler)) {
                return call_user_func_array($handler, $args);
            } elseif ($handler instanceof MiddlewareInterface) {
              // If it is a middleware interface, then we
              // process it
                return $handler->process($request, $next);
            }
            throw new InvalidArgumentException('Invalid callable handler provided');
        } else {
          // The handler might be in the format of a class
            if (is_string($handler)) {
                $handler = $this->createClass($handler, $args);
            } elseif (is_array($handler) && is_string($handler[0])) {
              // The handler might be in the format of a [class, method]
              // E.g: /App/Controller/HomeController:index
                list($class, $method) = $handler;
                $refMethod = new ReflectionMethod($class, $method);
                if (!$refMethod->isStatic()) {
                    $class = $this->createClass($class, $args);
                    $handler = [$class, $method];
                }
            }
            if (is_callable($handler)) {
                return call_user_func_array($handler, $args);
            } elseif ($handler instanceof MiddlewareInterface) {
              // If it is a middleware interface, then we
              // process it
                return $handler->process($request, $next);
            }
            throw new InvalidArgumentException('Invalid Callable Handler Provided');
        }
    }

  /**
   * Create a new class based on the container
   *
   * @param string $class
   *
   * @return object
   */
    private function createClassFromContainer($class)
    {
        if (method_exists($this->container, 'make')) {
            return $this->container->make($class);
        } else {
          // We assume that the other container has 'get' method
            return $this->container->get($class);
        }
    }

  /**
   * Create a new class.
   *
   * @param string $class
   * @param RequestInterface $request
   * @param array  $args
   *
   * @return object
   */
    private function createClass($class, $args = [])
    {
        if (!class_exists($class)) {
            throw new RuntimeException("Class {$class} Does Not Exist");
        }
        $refClass = new ReflectionClass($class);
        if ($refClass->hasMethod('__construct')) {
            return $refClass->newInstanceArgs($args);
        }
        return $refClass->newInstance();
    }
}
