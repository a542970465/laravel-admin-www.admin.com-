<?php

use Illuminate\Routing\Router;

Admin::registerAuthRoutes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index');

    $router->resource('movie', MovieController::class);
    $router->resource('profile', ProfileController::class);
    $router->resource('users', UserController::class);
//    $router->post('users','UserController@')


});
