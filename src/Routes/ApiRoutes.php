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
            $router->get('/waiterOrders', [\App\Controllers\APIv1Controller::class, 'waiterOrders']);
            $router->get('/productBreakdown', [\App\Controllers\APIv1Controller::class, 'productBreakdown']);
            $router->get('/paymentMethods', [\App\Controllers\APIv1Controller::class, 'paymentMethods']);
            $router->get('/staffPerformance', [\App\Controllers\APIv1Controller::class, 'staffPerformance']);
            $router->get('/kpiStats', [\App\Controllers\APIv1Controller::class, 'getKPIStats']);
            $router->get('/revenueByCategory', [\App\Controllers\APIv1Controller::class, 'revenueByCategory']);
            $router->get('/revenueByTable', [\App\Controllers\APIv1Controller::class, 'revenueByTable']);
            $router->get('/getAllUsers', [\App\Controllers\APIv1Controller::class, 'getAllUsers']);
            $router->get('/printers', [\App\Controllers\PrinterController::class, 'index']);
            $router->post('/printers/{printerId}/test', [\App\Controllers\PrinterController::class, 'testPrint']);
            $router->get('/printers/template', [\App\Controllers\PrinterController::class, 'getTemplate']);
            $router->post('/printers/template', [\App\Controllers\PrinterController::class, 'updateTemplate']);
            $router->post('/printers/template/preview', [\App\Controllers\PrinterController::class, 'previewTemplate']);
            $router->get('/getBusinessHours', [\App\Controllers\APIv1Controller::class, 'getBusinessHours']);
            $router->get('/getBranchHolidays', [\App\Controllers\APIv1Controller::class, 'getBranchHolidays']);
            $router->get('/inventory/items', [\App\Controllers\IngredientsController::class, 'getAllIngredients']);
            $router->post('/inventory/items', [\App\Controllers\IngredientsController::class, 'saveIngredient']);
            $router->delete('/inventory/items/{id}', [\App\Controllers\IngredientsController::class, 'removeIngredient']);
            $router->get('/suppliers', [\App\Controllers\SuppliersController::class, 'getSuppliers']);
            $router->post('/saveSettings', [\App\Controllers\APIv1Controller::class, 'saveSettings']);
            $router->post('/payment-methods/save', [\App\Controllers\PaymentController::class, 'savePaymentMethods']);
        });

        Router::group('/api/v1/handheld', function($router){
            $router->post('/login', [\App\Controllers\APIv1Controller::class, 'handheldLogin']);
            $router->post('/createOrder', [\App\Controllers\APIv1Controller::class, 'createOrder']);
            $router->post('/settle', [\App\Controllers\APIv1Controller::class, 'settle']);
            $router->post('/updateTableStatus/{table_no}', [\App\Controllers\APIv1Controller::class, 'updateTableStatus']);
        });
    }
}
