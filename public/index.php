<?php

require '../vendor/autoload.php';

use App\Core\Router;
use App\Routes\WebRoutes;
use App\Routes\ApiRoutes;
use App\Routes\AdminRoutes;
use App\Routes\HandheldRoutes;
use App\Middlewares\AuthMiddleware;
use App\Middlewares\HandheldAuthMiddleware;

date_default_timezone_set('Europe/Istanbul');

$middlewareStack = [
    HandheldAuthMiddleware::class,
    AuthMiddleware::class,
];

foreach ($middlewareStack as $middleware) {
    (new $middleware())->handle();
}

$router = new Router();

$routes = [
    WebRoutes::class,
    ApiRoutes::class,
    AdminRoutes::class,
    HandheldRoutes::class
];

foreach ($routes as $routeClass) {
    $routeClass::register($router);
}


$router->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);