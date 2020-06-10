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
    Route::get('/new',[ 
        'uses' => 'ProductController@newProduct',
        'as'   => 'admin.new'
    ]);
    Route::get('/products',[ 
        'uses' => 'ProductController@getIndex',
        'as'   => 'admin.products'
    ]);
    Route::get('/search',[
        'uses' => 'ProductController@search',
        'as'   => 'admin.search'
    ]);
    Route::get('/destroy/{id}',[ 
        'uses' => 'ProductController@destroy',
        'as'   => 'admin.destroy'
    ]);
    Route::post('/save',[ 
        'uses' => 'ProductController@add',
        'as'   => 'admin.save'
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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
