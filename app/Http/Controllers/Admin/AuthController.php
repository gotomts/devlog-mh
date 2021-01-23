<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\WebBaseController;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

/**
 * 管理画面側 認証コントローラ
 */
class AuthController extends WebBaseController
{
    // 認証用のtraitをインポート
    use AuthenticatesUsers;

    /**
     * ログイン後のリダイレクト先
     *
     * @var string
     */
    protected $redirectTo = 'admin/index';

    /**
     * ログアウト後のリダイレクト先
     * @var string
     */
    protected $loggedOutRedirectTo = 'admin';

    /**
     * 返却するguard
     *
     * @return string|null guard名
     */
    protected function guard()
    {
        return \Auth::guard('admin');
    }

    /**
     * ログアウト リダイレクト先
     *
     * @return Redirect
     */
    protected function loggedOut()
    {
        return redirect(url($this->loggedOutRedirectTo));
    }

    /**
     * 認証を処理する
     *
     * @param  Request $request
     *
     * @return Response
     */
    public function authenticated(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (\Auth::attempt($credentials)) {
            // 認証に成功した
            return redirect()->intended($this->redirectTo);
        }
    }

    /**
     * ログイン画面表示
     *
     * @return View
     */
    public function showLoginForm()
    {
        return \View::make('auth.login');
    }
}
