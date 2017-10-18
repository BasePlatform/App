<?php

require __DIR__.'/../vendor/autoload.php';

use Base\Http\RequestFactory;
use Base\Middleware\Dispatcher;
use Zend\Diactoros\Response\JsonResponse;

$container = null;

$middlewares = [
  function ($request, $next) {
    $response = new \Zend\Diactoros\Response();
    return new JsonResponse(['ack' => time()]);
  }
];

$dispatcher = new Dispatcher($middlewares, $container);

$response = $dispatcher->dispatch(RequestFactory::create());
// We have response, now we use an emitter to emit the response
// with header, body, status info
$emitter = new \Zend\Diactoros\Response\SapiEmitter();
$emitter->emit($response);

// $dispatcher = FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $r) {
//     $r->addRoute('GET', '/tenant/earth', 'App\Action\EarthAction');
//     $r->addRoute('POST', '/tenant/mars', 'App\Action\MarsAction');
// });

// // Fetch method and URI from somewhere
// $httpMethod = $_SERVER['REQUEST_METHOD'];
// $uri = $_SERVER['REQUEST_URI'];

// // Strip query string (?foo=bar) and decode URI
// if (false !== $pos = strpos($uri, '?')) {
//   $uri = substr($uri, 0, $pos);
// }
// $uri = rawurldecode($uri);

// $routeInfo = $dispatcher->dispatch($httpMethod, $uri);
// switch ($routeInfo[0]) {
//   case FastRoute\Dispatcher::NOT_FOUND:
//     echo 'NOT FOUND';
//     break;
//   case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
//     $allowedMethods = $routeInfo[1];
//     echo 'NOT ALLOWED';
//     break;
//   case FastRoute\Dispatcher::FOUND:
//     $handler = $routeInfo[1];
//     $vars = $routeInfo[2];
//     $action = new $handler();
//     return $action->handle(RequestFactory::create());
// }