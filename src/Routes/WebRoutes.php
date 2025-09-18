<?php
namespace App\Routes;

use App\Controllers\PagesController;

class WebRoutes
{
    public static function register(\App\Core\Router $router): void
    {
        $router->get('/login', [PagesController::class, 'login']);
    }
}
