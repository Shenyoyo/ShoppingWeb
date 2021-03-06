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
Route::group(['middleware' => ['setLocale']], function () {

//客端網址(購物網前台)
    Route::group(['domain' => 'shoppingweb.user.com'], function () {
        Route::get('/', function () {
            return redirect('shop');
        });
        //商品頁面
        Route::resource('shop', 'MainController', ['only' => ['index', 'show']]);
        Route::get('/changeLocale/{locale}', 'LanguageController@changeLocale');
        Route::get('/search', [
        'uses' => 'MainController@search',
        'as'   => 'shop.search'
        ]);
        Route::get('/orderby/{sort}', [
        'uses' => 'MainController@orderbyPorduct',
        'as'   => 'shop.orderby'
        ]);
        Route::get('/category/{id}/{orderby?}', [
        'uses' => 'MainController@categoryProduct',
        'as'   => 'shop.category'
        ]);
        //聯絡我們
        Route::get('/contact', [
        'uses' => 'ContactController@getIndex',
        'as'   => 'contact.index'
        ]);
        Route::post('/contact', [
        'uses' => 'ContactController@sendMessage',
        'as'   => 'contact.sendMessage'
        ]);

        //忘記密碼
        Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
        Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
        Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
        Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');

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
            Route::get('/profileEdit', [
            'uses'  => 'UserController@getProfileEdit' ,
            'as'   => 'user.profileEdit'
            ]);
            Route::post('/profileUpdate', [
            'uses'  => 'UserController@updateProfile' ,
            'as'   => 'user.updateProfile'
             ]);
            Route::post('/profile', [
            'uses'  => 'UserController@updatePassword' ,
            'as'   => 'user.updatePassword'
             ]);
            Route::get('/order', [
            'uses'  => 'UserController@getOrder' ,
            'as'   => 'user.order'
            ]);
            Route::get('/dollor', [
            'uses'  => 'UserController@getDollor' ,
            'as'   => 'user.dollor'
            ]);
            Route::get('/dollor/search', [
            'uses'  => 'UserController@searchDollor' ,
            'as'   => 'user.dollorSearch'
            ]);
            Route::get('/orderDetial/{id}', [
            'uses'  => 'UserController@getOrderDetail' ,
            'as'   => 'user.orderDetail'
            ]);
            Route::get('/message', [
            'uses'  => 'UserController@getMessage' ,
            'as'   => 'user.message'
            ]);
            Route::get('/messageShow/{id}', [
            'uses'  => 'UserController@getMessageShow' ,
            'as'   => 'user.messageShow'
            ]);
            Route::post('/show/reply', [
            'uses' => 'UserController@replyContact',
            'as'   => 'user.messageReply'
            ]);

            Route::post('/refund/', [
            'uses'  => 'UserController@refund' ,
            'as'   => 'user.refund'
            ]);
            Route::get('/confirm/{id}', [
            'uses'  => 'UserController@confirmOrder' ,
            'as'   => 'user.confirm'
            ]);
            Route::get('/logout', [
            'uses' => 'UserController@getLogout',
            'as' => 'user.logout'
            ]);
            Route::resource('cart', 'CartController');
            Route::delete('emptyCart', 'CartController@emptyCart');
            Route::patch('/cart/{id}', 'CartController@update')->name('cart.update');
            Route::post('/cart/dollor', 'CartController@dollor')->name('cart.dollor');
            Route::post('/cart/checkout', 'CartController@checkout')->name('cart.checkout');
            Route::post('/cart/buy', 'CartController@buy')->name('cart.buy');
        });
    });



    //管端網址(購物網後台)
    Route::group(['domain' => 'shoppingweb.admin.com'], function () {
        Route::get('/', [
        'uses' => 'AdminController@getIndex',
        'as'   => 'admin.login'
        ]);
        Route::post('/', [
        'uses' => 'AdminController@postLogin',
        'as'   => 'admin.login'
        ]);
        Route::get('/changeLocale/{locale}', 'LanguageController@changeLocale');
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
                'uses' => 'CategoryController@addCategory',
                'as'   => 'category.add'
                ]);
                Route::post('/update', [
                'uses' => 'CategoryController@updateCategory',
                'as'   => 'category.update'
                ]);
                Route::get('/destroy/{id}', [
                'uses' => 'CategoryController@destroyCategory',
                'as'   => 'category.destroy'
                ]);
                Route::get('/search', [
                'uses' => 'CategoryController@searchCategory',
                'as'   => 'category.search'
                ]);
            });

            Route::group(['prefix' => 'level'], function () {
                Route::get('/', [
                'uses' => 'LevelController@getIndex',
                'as'   => 'level.index'
                ]);
                Route::get('/new', [
                'uses' => 'LevelController@newLevel',
                'as'   => 'level.new'
                ]);
                Route::get('/edit/{id}', [
                'uses' => 'LevelController@editLevel',
                'as'   => 'level.edit'
                ]);
                Route::post('/add', [
                'uses' => 'LevelController@addLevel',
                'as'   => 'level.add'
                ]);
                Route::post('/update', [
                'uses' => 'LevelController@updateLevel',
                'as'   => 'level.update'
                ]);
                Route::get('/destroy/{id}', [
                'uses' => 'LevelController@destroyLevel',
                'as'   => 'level.destroy'
                ]);
                Route::get('/search', [
                'uses' => 'LevelController@searchLevel',
                'as'   => 'level.search'
                ]);
            });
            Route::group(['prefix' => 'offer'], function () {
                Route::get('/', [
                'uses' => 'OfferController@getIndex',
                'as'   => 'offer.index'
                ]);
                Route::get('/new', [
                'uses' => 'OfferController@newOffer',
                'as'   => 'offer.new'
                ]);
                Route::get('/edit/{id}', [
                'uses' => 'OfferController@editOffer',
                'as'   => 'offer.edit'
                ]);
                Route::post('/add', [
                'uses' => 'OfferController@addOffer',
                'as'   => 'offer.add'
                ]);
                Route::post('/update', [
                'uses' => 'OfferController@updateOffer',
                'as'   => 'offer.update'
                ]);
                Route::get('/destroy/{id}', [
                'uses' => 'OfferController@destroyOffer',
                'as'   => 'offer.destroy'
                ]);
                Route::get('/search', [
                'uses' => 'OfferController@searchOffer',
                'as'   => 'offer.search'
                ]);
            });
            Route::group(['prefix' => 'order'], function () {
                Route::get('/', [
                'uses' => 'OrderController@getIndex',
                'as'   => 'order.index'
                ]);
                Route::get('/sand/{id}', [
                'uses' => 'OrderController@sandProduct',
                'as'   => 'order.sand'
                ]);
                Route::get('/refundAgree/{id}', [
                'uses' => 'OrderController@refundAgree',
                'as'   => 'order.refundAgree'
                ]);
                Route::post('/refundDisagree', [
                'uses' => 'OrderController@refundDisagree',
                'as'   => 'order.refundDisagree'
                ]);
                Route::get('/show/{id}', [
                'uses' => 'OrderController@showOrder',
                'as'   => 'order.show'
                ]);
                Route::get('/search', [
                'uses' => 'OrderController@searchOrder',
                'as'   => 'order.search'
                ]);
                Route::get('/orderbyStatus', [
                'uses' => 'OrderController@orderbyStatus',
                'as'   => 'order.orderby'
                ]);
            });
            Route::group(['prefix' => 'user'], function () {
                Route::get('/', [
                'uses' => 'AdminUserController@getIndex',
                'as'   => 'adminUser.index'
                ]);
                Route::get('/edit/{id}', [
                'uses' => 'AdminUserController@editUser',
                'as'   => 'adminUser.edit'
                ]);
                Route::get('/deposit/{id}', [
                'uses' => 'AdminUserController@getDepositIndex',
                'as'   => 'adminUser.deposit'
                ]);
                Route::post('/deposit/', [
                'uses' => 'AdminUserController@postDeposit',
                'as'   => 'adminUser.postDeposit'
                ]);
                Route::get('/withdraw/{id}', [
                'uses' => 'AdminUserController@getWithdrawIndex',
                'as'   => 'adminUser.withdraw'
                ]);
                Route::post('/withdraw/', [
                'uses' => 'AdminUserController@postWithdraw',
                'as'   => 'adminUser.postWithdraw'
                ]);
                Route::post('/update', [
                'uses' => 'AdminUserController@updateUser',
                'as'   => 'adminUser.update'
                ]);
                Route::get('/resetPassword/{id}', [
                'uses' => 'AdminUserController@resetPassword',
                'as'   => 'adminUser.resetPassword'
                ]);
                Route::post('/updatePassword', [
                'uses' => 'AdminUserController@updatePassword',
                'as'   => 'adminUser.updatePassword'
                ]);
                Route::get('/search', [
                'uses' => 'AdminUserController@searchUser',
                'as'   => 'adminUser.search'
                ]);
            });
            Route::group(['prefix' => 'contact'], function () {
                Route::get('/', [
                'uses' => 'AdminContactController@getIndex',
                'as'   => 'adminContact.index'
                ]);
                Route::get('/show/{id}', [
                'uses' => 'AdminContactController@showContact',
                'as'   => 'adminContact.show'
                ]);
                Route::post('/show/reply', [
                'uses' => 'AdminContactController@replyContact',
                'as'   => 'adminContact.reply'
                ]);
                Route::get('/show/lock/{id}', [
                'uses' => 'AdminContactController@lockContact',
                'as'   => 'adminContact.lock'
                ]);
                Route::get('/show/unlock/{id}', [
                'uses' => 'AdminContactController@unlockContact',
                'as'   => 'adminContact.unlock'
                ]);
                Route::get('/orderbyStatus', [
                'uses' => 'AdminContactController@orderbyStatus',
                'as'   => 'adminContact.orderby'
                ]);
                Route::get('/search', [
                'uses' => 'AdminContactController@searchContact',
                'as'   => 'adminContact.search'
                ]);
            });
            Route::group(['prefix' => 'dollor'], function () {
                Route::get('/', [
                'uses' => 'DollorController@getIndex',
                'as'   => 'dollor.index'
                ]);
                Route::get('/search', [
                'uses' => 'DollorController@searchDollor',
                'as'   => 'dollor.search'
                ]);
            });
        });
    });
});
