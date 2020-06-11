<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [
    'uses' => 'MainController@getIndex',
    'as'    => 'shop.index'
]);

Route::group(['prefix' => 'user'], function () {
    Route::group(['middleware' => ['guest']], function () {
        Route::get('/signup', [
            'uses' => 'UserController@getSignup',
            'as'    => 'user.signup'
            
            ]);
        
        Route::post('/signup', [
            'uses' => 'UserController@postSignup',
            'as'    => 'user.signup',
            
            ]);
        Route::get('/signin', [
            'uses' => 'UserController@getSignin',
            'as'    => 'user.signin'
            
            ]);
        
        Route::post('/signin', [
            'uses' => 'UserController@postSignin',
            'as'    => 'user.signin'
             ]);
    });
    
    Route::group(['middleware' => ['auth']], function () {
        Route::get('/profile', [
            'uses'  => 'UserController@getProfile' ,
            'as'   => 'user.profile'
            ]);
        
        Route::get('/logout', [
            'uses' => 'UserController@getLogout',
            'as' => 'user.logout'
            ]);
    });
});

Route::group(['prefix' => 'admin'], function () {

    Route::get('/login', [
        'uses' => 'AdminController@getIndex',
        'as'   => 'admin.login'
    ]);
    Route::post('/login', [
        'uses' => 'AdminController@postLogin',
        'as'   => 'admin.login'
    ]);

    Route::group(['middleware' => ['adminVerify']], function () {
        Route::get('/logout', [
            'uses' => 'AdminController@getLogout',
            'as'   => 'admin.logout'
        ]);
    
    
        Route::group(['prefix' => 'stock'], function () {
            Route::get('/new', [
                'uses' => 'ProductController@newProduct',
                'as'   => 'admin.new'
            ]);
            Route::get('/products', [
                'uses' => 'ProductController@getIndex',
                'as'   => 'admin.products'
            ]);
            Route::get('/search', [
                'uses' => 'ProductController@search',
                'as'   => 'admin.search'
            ]);
            Route::get('/destroy/{id}', [
                'uses' => 'ProductController@destroy',
                'as'   => 'admin.destroy'
            ]);
            Route::post('/add', [
                'uses' => 'ProductController@add',
                'as'   => 'admin.add'
            ]);
            Route::get('/edit/{id}', [
                'uses' => 'ProductController@edit',
                'as'   => 'admin.edit'
            ]);
            Route::post('/update', [
                'uses' => 'ProductController@update',
                'as'   => 'admin.update'
            ]);
        });
    
        Route::group(['prefix' => 'category'], function () {
            Route::get('/', [
                'uses' => 'CategoryController@getIndex',
                'as'   => 'category.index'
            ]);
            Route::get('/new', [
                'uses' => 'CategoryController@newCategory',
                'as'   => 'category.new'
            ]);
            Route::get('/edit/{id}', [
                'uses' => 'CategoryController@editCategory',
                'as'   => 'category.edit'
            ]);
            Route::post('/add', [
                'uses' => 'CategoryController@add',
                'as'   => 'category.add'
            ]);
            Route::post('/update', [
                'uses' => 'CategoryController@update',
                'as'   => 'category.update'
            ]);
            Route::get('/destroy/{id}', [
                'uses' => 'CategoryController@destroy',
                'as'   => 'category.destroy'
            ]);
            Route::get('/search', [
                'uses' => 'CategoryController@search',
                'as'   => 'category.search'
            ]);
        });
        
    });

    
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
