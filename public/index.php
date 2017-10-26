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

use Base\Http\RequestFactory;
use Base\Middleware\Dispatcher;

require __DIR__.'/../bootstrap/autoload.php';

/**
 * Get the container
 */
$container = require_once __DIR__.'/../bootstrap/container.php';

/**
 * Get the route dispatcher
 */
$routeDispatcher = require_once __DIR__.'/../bootstrap/route-dispatcher.php';;

/**
 * Setup the middleware queue
 */
$middlewares = [
  Base\Middleware\ErrorHandlerMiddleware::class,
  new Base\Middleware\FastRouteMiddleware($routeDispatcher),
  new Base\Middleware\RequestHandlerMiddleware($container)
];

/**
 * Dispatch the request through middleware queue and get a response
 */
$dispatcher = new Dispatcher($middlewares, $container);
$response = $dispatcher->dispatch(RequestFactory::create());

/**
 * Return the response
 */
$emitter = new \Zend\Diactoros\Response\SapiEmitter();
$emitter->emit($response);