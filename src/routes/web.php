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
    Route::post('admin/logout', 'Auth\LoginController@logout')->name('logout');
});

Route::group(['middleware' => 'guest'], function () {
    Route::group(['prefix' => 'admin'], function () {
        // ログイン
        Route::get('/', 'Auth\LoginController@showLoginForm')->name('login');
        Route::post('/', 'Auth\LoginController@login');
        // パスワードリセット
        Route::get('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
        Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
        Route::post('password/reset', 'Auth\ForgotPasswordController@reset')->name('password.update');
        Route::get('password/reset/{token}', 'Auth\ForgotPasswordController@showResetForm')->name('password.reset');
    });
});

Route::group(['middleware' => 'auth'], function () {
    Route::group(['prefix' => 'admin'], function () {
        // ログイン後TOP
        Route::get('index', 'Admin\IndexController@showIndex');
        // 記事
        Route::group(['prefix' => 'post'], function () {
            Route::get('/', 'Admin\PostController@showIndex');
            Route::get('create', 'Admin\PostController@showCreate');
            Route::post('create', 'Admin\PostController@exeCreate');
            Route::get('edit/{id}', 'Admin\PostController@showEdit');
            Route::post('edit/{id}', 'Admin\PostController@exeEdit');
        });
        // カテゴリー
        Route::group(['prefix' => 'category'], function () {
            Route::get('/', 'Admin\CategoryController@showList');
            Route::get('create', 'Admin\CategoryController@showCreate');
            Route::post('create', 'Admin\CategoryController@exeCreate');
            Route::get('edit/{id}', 'Admin\CategoryController@showEdit');
            Route::post('edit/{id}', 'Admin\CategoryController@exeEdit');
        });
        // ユーザ管理
        Route::group(['prefix' => 'user'], function () {
            Route::get('/', 'Admin\UserController@showList');
            Route::get('create', 'Admin\UserController@showCreate');
            Route::post('create', 'Admin\UserController@exeCreate');
            Route::get('edit/{id}', 'Admin\UserController@showEdit');
            Route::post('edit/{id}', 'Admin\UserController@exeEdit');
        });
        // 画像管理
        Route::group(['prefix' => 'image'], function () {
            Route::get('/', 'Admin\ImageController@showList');
            Route::post('upload', 'Admin\ImageController@exeUpload');
            Route::get('upload', 'Admin\ImageController@showUpload');
            Route::post('create', 'Admin\ImageController@exeCreate');
            Route::get('edit/{id}', 'Admin\ImageController@showEdit');
            Route::post('edit/{id}', 'Admin\ImageController@exeEdit');
        });
        // プロフィール編集
        Route::group(['prefix' => 'profile'], function () {
            Route::get('edit', 'Admin\ProfileController@showEdit');
            Route::post('edit', 'Admin\ProfileController@exeEdit');
        });
    });
});
