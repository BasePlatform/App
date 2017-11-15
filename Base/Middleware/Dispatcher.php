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
 * PSR-7 / PSR-15 middleware dispatcher
 *
 * Based on the work of https://github.com/oscarotero/middleland/blob/master/src/Dispatcher.php
 *
 * This class only restructures and provides additional comments for
 * explaining how a Dispatcher works based on the beautiful work of above class of oscarotero
 *
 * It also adds a small change to support make() method
 * of Auryn container and removes the requirements of ContainerInterface in construction method
 *
 * @package Base\Middleware
 */
class Dispatcher implements DispatcherInterface
{
    /**
     * @var MiddlewareInterface[] queue
     */
    private $middlewares;

    /**
     * @var object
     */
    private $container;

    /**
     * @param MiddlewareInterface[] $middleware
     *
     * @param object $container
     */
    public function __construct(array $middlewares, $container = null)
    {
        if (empty($middlewares)) {
            throw new InvalidArgumentException('Missing Middleware Definition');
        }
        $this->middlewares = $middlewares;
        $this->container = $container;
    }

    /**
     * {@inheritdoc}
     */
    public function dispatch(ServerRequestInterface $request): ResponseInterface
    {
        reset($this->middlewares);
        return $this->getMiddleware($request)->process($request, $this->createRequestHandler());
    }

    /**
     * This function get the current first middleware definition of the
     * middlewares array and create a Middleware Instance based on the
     * type of the definitions
     *
     * @param ServerRequestInterface $request
     *
     * @return MiddlewareInterface|false
     */
    public function getMiddleware(ServerRequestInterface $request): MiddlewareInterface
    {
        // Get the current middleware definition
        $middlewareDefinition = current($this->middlewares);

        if ($middlewareDefinition === false) {
            return $middlewareDefinition;
        }

        // If this is an array, we will set the middlewareDefinition to the last element of the array
        // Then we check all the conditions which are the remaining items of the array.
        // If they pass all, the middlewareDefinition will be created
        //
        if (is_array($middlewareDefinition)) {
            $conditions = $middlewareDefinition;
            $middlewareDefinition = array_pop($conditions);
            foreach ($conditions as $condition) {
                if ($condition === true) {
                    continue;
                }
                if ($condition === false) {
                    return $this->getNextMiddleware($request);
                }
                if (is_string($condition) && $condition[0] == '/') {
                    $declaredPath = $condition;
                    $path = $request->getUri()->getPath();
                    $checkPathResult = (($path === $declaredPath) || stripos($path, $declaredPath.'/') === 0);
                    if ($checkPathResult) {
                        continue;
                    } else {
                        return $this->getNextMiddleware($request);
                    }
                } elseif (!is_callable($condition)) {
                    throw new InvalidArgumentException('Invalid Condition Middleware Provided');
                }
                if (!$condition($request)) {
                    return $this->getNextMiddleware($request);
                }
            }
        }

        // Middleware is defined through a class of string
        // E.g \App\Middleware\SampleMiddleware
        //
        if (is_string($middlewareDefinition)) {
            // If we do not provide a container
            // so that we cannot create an instance of the provided class
            if ($this->container === null) {
                throw new InvalidArgumentException(sprintf('Invalid Middleware Provided `%s`', $middlewareDefinition));
            }
            // A small tweak for supporting
            // the make() function of Auryn dependency injector
            if (method_exists($this->container, 'make')) {
                return $this->container->make($middlewareDefinition);
            } else {
              // We assume that the other container has 'get' method
                return $this->container->get($middlewareDefinition);
            }
        }

        // Direct middleware instance
        if ($middlewareDefinition instanceof MiddlewareInterface) {
            return $middlewareDefinition;
        }

        if ($middlewareDefinition instanceof Closure) {
            return $this->createMiddlewareFromClosure($middlewareDefinition);
        }

        throw new InvalidArgumentException(sprintf('Invalid Middleware Provided `%s`', is_object($middlewareDefinition) ? get_class($middlewareDefinition) : gettype($middlewareDefinition)));
    }

    /**
     * Return the next available middleware in the queue.
     *
     * @return MiddlewareInterface|false
     */
    public function getNextMiddleware(ServerRequestInterface $request): MiddlewareInterface
    {
        next($this->middlewares);
        return $this->getMiddleware($request);
    }

    /**
     * Create a request handler for the current queue
     *
     * @param RequestHandlerInterface $next
     *
     * @return RequestHandlerInterface
     */
    private function createRequestHandler(RequestHandlerInterface $next = null): RequestHandlerInterface
    {
        return new DelegateRequestHandler($this, $next);
    }

    /**
     * Create a middleware from a closure
     *
     * @param Closure $handler
     *
     * @return MiddlewareInterface
     */
    private function createMiddlewareFromClosure(Closure $handler): MiddlewareInterface
    {
        return new DelegateClosureMiddleware($handler);
    }
}
