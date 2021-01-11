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
    Route::group(['middleware' => ['front']], function () {
        // ブログトップ
        Route::get('/', 'BlogController@showIndex');
        // ブログ詳細
        Route::get('blog/{url}', 'BlogController@showDetail');
        // カテゴリー絞り込み
        Route::get('category/{categoryName}', 'BlogController@showCategory');

        Route::group(['prefix' => 'member'], function () {
            // コンテンツ側ログアウト
            Route::post('logout', 'MemberController@logout')->name('logout');
            // 会員限定機能 未ログイン
            Route::group(['middleware' => 'guest:member'], function () {
                // ログイン
                Route::get('/', 'MemberController@showLoginForm');
                Route::post('/', 'MemberController@login');
                // 仮会員登録
                Route::get('verify', 'MemberController@showVerifyRegister');
                // 仮会員登録確認
                Route::post('verify/confirm', 'MemberController@exeVerifyRegisterConfirm');
                Route::get('verify/confirm', 'MemberController@showVerifyRegisterConfirm');
                // 仮会員登録完了
                Route::post('verify/complete', 'MemberController@exeVerifyRegisterComplete');
                Route::get('verify/complete', 'MemberController@showVerifyRegisterComplete');
                // 会員登録
                Route::get('register/{token}', 'MemberController@showRegister');
            });
            // 会員限定機能 ログイン済み
            Route::group(['middleware' => 'auth:member'], function () {
            });
        });
    });

    // 管理画面
    Route::group(['prefix' => 'admin'], function () {
        // 管理画面側ログアウト
        Route::post('logout', 'Auth\LoginController@logout')->name('logout');
        // 管理画面 未ログイン
        Route::group(['middleware' => 'guest:admin'], function () {
            // ログイン
            Route::get('/', 'Auth\LoginController@showLoginForm')->name('login');
            Route::post('/', 'Auth\LoginController@login');
            // パスワードリセット
            Route::get('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
            Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
            Route::post('password/reset', 'Auth\ForgotPasswordController@reset')->name('password.update');
            Route::get('password/reset/{token}', 'Auth\ForgotPasswordController@showResetForm')->name('password.reset');
        });

        // 管理画面 ログイン済み
        Route::group(['middleware' => 'auth:admin'], function () {
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
});
