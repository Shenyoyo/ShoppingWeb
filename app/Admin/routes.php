<?php

use Illuminate\Routing\Router;


Admin::routes();
Route::group([
    'prefix'        => config('admin.route.prefix'),
    // 'as'            => config('admin.route.prefix') . '.',
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
    'domain'        => config('admin.route.domain'),
], function (Router $router) {

    $router->get('/', 'HomeController@index')->name('home');

    $router->resource('products', ProductController::class);
    $router->resource('catagories', CategoryController::class);
    $router->resource('levels', LevelController::class);

});
