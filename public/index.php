<?php
error_reporting(E_ALL & ~E_USER_DEPRECATED & ~E_DEPRECATED & ~E_STRICT & ~E_NOTICE);

require __DIR__.'/../vendor/autoload.php';

use Base\Http\RequestFactory;
use Base\Middleware\Dispatcher;
use Psr\Log\LoggerInterface;
use Monolog\Logger;
use Monolog\Handler\SyslogHandler;

$container = new Auryn\Injector;

// We set to use the default ResponseFactory of BasePlatform
$container->alias(Base\Http\ResponseFactoryInterface::class, Base\Http\ResponseFactory::class);

$container->alias(Psr\Log\LoggerInterface::class, Monolog\Logger::class);

// Create the logger
$logger = new Logger('logger');
// Now add some handlers
$logger->pushHandler(new \Monolog\Handler\ErrorLogHandler());

$container->share($logger);

$routeDispatcher = \FastRoute\simpleDispatcher(function (\FastRoute\RouteCollector $r) {
  $r->addRoute(['POST'], '/tenants/register', \Base\TenantService\Controller\Tenant\TenantController::class.':'.'register');
  $r->addRoute(['GET'], '/admin/tenants/self/settings[/{group}]', \Base\TenantService\Controller\Tenant\TenantAdminController::class.':'.'getSettings');
});

$middlewares = [
  Base\Middleware\ErrorHandlerMiddleware::class,
  new Base\Middleware\FastRouteMiddleware($routeDispatcher),
  new Base\Middleware\RequestHandlerMiddleware($container)
];

$dispatcher = new Dispatcher($middlewares, $container);

$response = $dispatcher->dispatch(RequestFactory::create());
// We have response, now we use an emitter to emit the response
// with header, body, status info
$emitter = new \Zend\Diactoros\Response\SapiEmitter();
$emitter->emit($response);