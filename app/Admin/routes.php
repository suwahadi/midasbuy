<?php

use Illuminate\Routing\Router;

Admin::routes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
    'as'            => config('admin.route.prefix') . '.',
], function (Router $router) {

    $router->get('/', 'HomeController@index')->name('home');
    $router->resource('products', ProductsController::class);
    $router->resource('items', ItemsController::class);
    $router->resource('users', UsersController::class);
    $router->resource('banners', BannersController::class);
    $router->resource('news', NewsController::class);
    $router->resource('payment-channels', PaymentChannelsController::class);
    $router->resource('deposit', DepositController::class);
    $router->resource('logs', UserLogsController::class);
    $router->resource('transactions', TransactionsController::class);
    $router->resource('pages', PagesController::class);
    $router->resource('mutasi', TransfersController::class);
    $router->resource('sms', SMSNotifController::class);
    $router->get('sms/create', 'CreateSMSController@index');
});