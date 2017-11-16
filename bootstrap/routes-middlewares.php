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

return function ($container) {

    $routesMiddlewares = [];

    /**
     * Define routes based on the config routes and cache it
     */
    $routeDispatcher = \FastRoute\cachedDispatcher(function (\FastRoute\RouteCollector $r) {
        $routes = \Base\Service::$config->get('routes');
        if (is_array($routes) && !empty($routes)) {
            foreach ($routes as $route) {
                $enabled = $route['enabled'] ?? true;
                if ($enabled) {
                    $r->addRoute($route['allowedMethods'], $route['path'], $route['handler']);
                }
            }
        }
    }, [
        'cacheFile' => __DIR__.'/../runtime/cache/routes.php',
        'cacheDisabled' => env('APP_DEBUG', false)
    ]);

    /**
     * Setup the middleware queue
     */
    $middlewares = [
        Base\Middleware\RequestIdMiddleware::class,
        Base\Middleware\ErrorHandlerMiddleware::class,
        new Base\Middleware\FastRouteMiddleware($routeDispatcher),
        /**
         * Insert additional middlewares here
         */
    ];

    /**
     * Uncomment this if you want to have custom middlewares per route
     */
    // $routes = \Base\Service::$config->get('routes');
    // if (is_array($routes) && !empty($routes)) {
    //     foreach ($routes as $route) {
    //         $enabled = $route['enabled'] ?? true;
    //         $routeMiddlewares = (isset($route['middlewares']) && is_array($route['middlewares']) && !empty($route['middlewares'])) ? $route['middlewares'] : null;
    //         if ($enabled && $routeMiddlewares) {
    //             foreach ($routeMiddlewares as $middleware) {
    //                 $middlewares[] = [$route['path'], $middleware];
    //             }
    //         }
    //     }
    // }

    /**
     * Setup for request handlers and body parser middlewares
     */
    $middlewares[] = new Base\Middleware\BodyParserMiddleware('urlencoded');
    $middlewares[] = new Base\Middleware\BodyParserMiddleware('json');
    $middlewares[] = new Base\Middleware\RequestHandlerMiddleware($container);

    return $middlewares;
};
