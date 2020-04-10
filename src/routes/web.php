<?php

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




Route::group(['middleware' => 'web'], function () {
    // ブログトップ
    Route::get('/', 'IndexController@showIndex');
    // ブログ詳細
    // Route::get('{id}', 'BlogController@showDetail');
    // カテゴリー絞り込み
    // Route::get('category-post/{categoryName}', 'CategoryPostController@showIndex');
    // ログアウト
    Route::post('mh-login/logout', 'Auth\LoginController@logout')->name('logout');
});

Route::group(['middleware' => 'guest'], function () {
    // ログイン
    Route::get( 'mh-login',                    'Auth\LoginController@showLoginForm')->name('login');
    Route::post('mh-login',                    'Auth\LoginController@login');
    Route::group(['prefix' => 'mh-login'], function () {
        // パスワードリセット
        Route::get( 'password/email',           'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
        Route::get( 'password/reset',           'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
        Route::post('password/reset',           'Auth\ForgotPasswordController@reset')->name('password.update');
        Route::get( 'password/reset/{token}',   'Auth\ForgotPasswordController@showResetForm')->name('password.reset');
    });
});

Route::group(['middleware' => 'auth'], function() {
    Route::group(['prefix' => 'mh-login'], function () {
        // ログイン後TOP
        Route::get( 'home',                     'HomeController@showHome')->name('home');
        // // 記事
        // Route::group(['prefix' => 'post'], function () {
        //     Route::get( '/',                'PostController@showIndex');
        //     Route::get( 'create',           'PostController@showCreate');
        //     Route::post('create',           'PostController@exeCreate');
        //     Route::get( '{id}',             'PostController@showEdit');
        //     Route::match(['put', 'patch'],  '{id}', 'PostController@exeEdit');
        // });
        // カテゴリー
        Route::group(['prefix' => 'category'], function () {
            Route::get( '/',                'CategoryController@showList');
            Route::get( 'create',           'CategoryController@showCreate');
            Route::post('create',           'CategoryController@exeCreate');
            Route::get( '{id}',             'CategoryController@showEdit');
            Route::match(['put', 'patch'],  '{id}', 'CategoryController@exeEdit');
        });
        // ユーザ管理
        Route::group(['prefix' => 'user'], function () {
            Route::get( '/',                'UserController@showList');
            Route::get( 'create',           'UserController@showCreate');
            Route::post('create',           'UserController@exeCreate');
            Route::get( '{id}',             'UserController@showEdit');
            Route::match(['put', 'patch'],  '{id}', 'UserController@exeEdit');
        });
        /*
        // 画像管理
        Route::group(['prefix' => 'image'], function () {
            Route::get( '/',                'ImageController@showList');
            Route::get( 'create',           'ImageController@showCreate');
            Route::post('create',           'ImageController@exeCreate');
            Route::get( '{id}',             'ImageController@showEdit');
            Route::match(['put', 'patch'],  '{id}', 'ImageController@exeEdit');
        });
        // プロフィール編集
        Route::group(['prefix' => 'profile'], function () {
            Route::get( '/', 'ProfileController@showEdit');
            Route::match(['put', 'patch'],  '/', 'ProfileController@exeEdit');
        });
        */
    });
});
