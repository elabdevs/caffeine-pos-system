<?php
namespace App\Routes;

use App\Controllers\PagesController;

class AdminRoutes
{
    public static function register(\App\Core\Router $router): void
    {
        $router->get('/admin', function() {
            header('Location: /admin/');
            exit;
        });
        $router->group('/admin', function($router) {
            $router->get('/', [PagesController::class, 'dashboard']);
            $router->get('/analytics', [PagesController::class, 'settings/analytics']);
            $router->get('/general', [PagesController::class, 'settings/general']);
            $router->get('/hardware', [PagesController::class, 'settings/hardware']);
            $router->get('/integrations', [PagesController::class, 'settings/integrations']);
            $router->get('/inventory', [PagesController::class, 'settings/inventory']);
            $router->get('/inventory/recipes', [PagesController::class, 'settings/recipes']);
            $router->get('/notifications', [PagesController::class, 'settings/notifications']);
            $router->get('/payments', [PagesController::class, 'settings/payments']);
            $router->get('/products', [PagesController::class, 'settings/products']);
            $router->get('/reports', [PagesController::class, 'settings/reports']);
            $router->get('/security', [PagesController::class, 'settings/security']);
            $router->get('/users', [PagesController::class, 'settings/users']);
        });
    }
}
