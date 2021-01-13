<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\WebBaseController;
use Illuminate\Http\Request;

/**
 * 管理画面側 認証コントローラ
 */
class AuthController extends WebBaseController
{
    /**
     * ログイン画面表示
     *
     * @return View
     */
    public function showLogin()
    {
        return \View::make('auth.login');
    }

    /**
     * ログイン実行
     *
     * @param Request $request
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function exeLogin(Request $request)
    {
        // ログイン情報取得
        $input['email'] = $request->email;
        $input['password'] = $request->password;
        // ログイン
        if (\Auth::guard('admin')->attempt($input)) {
            return redirect('/admin/index');
        }
        return redirect('/');
    }

    /**
     * ログアウト
     *
     * @param Request $request
     */
    public function exeLogout()
    {
        \Auth::guard('admin')->logout();
        return redirect('/admin');
    }
}
