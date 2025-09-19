<?php
namespace App\Routes;

use App\Core\Router;

class ApiRoutes
{
    public static function register(\App\Core\Router $router): void
    {
        Router::group('/api/v1', function($router){
            $router->post('/login', [\App\Controllers\APIv1Controller::class, 'login']);
            $router->get('/users', [\App\Controllers\APIv1Controller::class, 'getUsers']);
            $router->get('/getWaiters', [\App\Controllers\APIv1Controller::class, 'getWaiters']);
            $router->get('/getDashboardData', [\App\Controllers\APIv1Controller::class, 'getDashboardData']);
            $router->get('/getRevenueTimeseries', [\App\Controllers\APIv1Controller::class, 'getRevenueTimeseries']);
            
        });

        Router::group('/api/v1/handheld', function($router){
            $router->post('/login', [\App\Controllers\APIv1Controller::class, 'handheldLogin']);
            $router->post('/createOrder', [\App\Controllers\APIv1Controller::class, 'createOrder']);
            $router->post('/settle', [\App\Controllers\APIv1Controller::class, 'settle']);
            $router->post('/updateTableStatus/{table_no}', [\App\Controllers\APIv1Controller::class, 'updateTableStatus']);
        });
    }
}
