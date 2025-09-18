<?php
namespace App\Routes;

use App\Controllers\PagesController;

class HandheldRoutes
{
    public static function register(\App\Core\Router $router): void
    {
        $router->get('/handheld', function() {
            header('Location: /handheld/');
            exit;
        });
        $router->group('/handheld', function($router) {
            $router->get('/', [PagesController::class, 'handheld/login']);
            $router->get('/dashboard', [PagesController::class, 'handheld/dashboard']);
            $router->get('/tables', [PagesController::class, 'handheld/tables']);
            $router->get('/table/{code}', [PagesController::class, 'handheld/table']);
            $router->get('/payment/{code}', [PagesController::class, 'handheld/payment']);
        });
    }
}
