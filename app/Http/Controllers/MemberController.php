<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Admin\WebBaseController;
use App\Mail\MemberRegisterMail;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MemberController extends WebBaseController
{
    use AuthenticatesUsers;

    /**
     * ログイン後のリダイレクト先
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:member')->except('logout');
    }

    /**
     * 返却するguard
     *
     * @return void
     */
    protected function guard()
    {
        return \Auth::guard('member');
    }

    /**
     * ログアウト
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    protected function loggedOut(Request $request)
    {
        return redirect(url($this->redirectTo));
    }

    /**
     * ログイン画面表示
     *
     * @return View
     */
    public function showLoginForm()
    {
        return \View::make('front.member.login');
    }

    /**
     * 仮登録画面表示
     */
    public function showAdvanceRegister()
    {
        return \View::make('front.member.advance_register');
    }

    // /**
    //  * 仮登録実行
    //  */
    // public function exeAdvanceRegister(Request $request)
    // {
    //     Mail::to($request->email)->send(new MemberRegisterMail());
    // }

    // /**
    //  * 会員登録画面
    //  */
    // public function showRegister()
    // {
    // }

    // /**
    //  * 会員登録実行
    //  */
    // public function exeRegister()
    // {
    // }
}
