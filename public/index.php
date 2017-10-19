<?php

require __DIR__.'/../vendor/autoload.php';

use Base\Http\RequestFactory;
use Base\Middleware\Dispatcher;

$container = new Auryn\Injector;

// We set to use the default ResponseFactory of BasePlatform
$container->alias(Base\Http\ResponseFactoryInterface::class, Base\Http\ResponseFactory::class);

$middlewares = [
  ['/earth', '\App\Action\EarthAction']
];

$dispatcher = new Dispatcher($middlewares, $container);

$response = $dispatcher->dispatch(RequestFactory::create());
// We have response, now we use an emitter to emit the response
// with header, body, status info
$emitter = new \Zend\Diactoros\Response\SapiEmitter();
$emitter->emit($response);