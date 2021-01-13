<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\WebBaseController;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends WebBaseController
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * ログイン後のリダイレクト先
     *
     * @var string
     */
    protected $redirectTo = 'admin';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:admin')->except('logout');
    }

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
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    protected function loggedOut(Request $request)
    {
        return redirect(url($this->redirectTo));
    }

    /**
     * 認証を処理する
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return Response
     */
    public function authenticated(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (\Auth::attempt($credentials)) {
            // 認証に成功した
            return redirect()->intended('admin/index');
        }
    }
}
