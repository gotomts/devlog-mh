<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Admin\WebBaseController;
use App\Http\Requests\Front\Member\MemberVerifyRequest;
use App\Mail\MemberRegisterCompleteMail;
use App\Mail\MemberVerifyMail;
use App\Models\Member;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

/**
 * コンテンツ側 認証コントローラ
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
    protected $redirectTo = 'member/index';

    /**
     * ログアウト後のリダイレクト先
     * @var string
     */
    protected $loggedOutRedirectTo = 'member';

    /**
     * 返却するguard
     *
     * @return string|null guard名
     */
    protected function guard()
    {
        return \Auth::guard('member');
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
        return \View::make('front.member.login');
    }

    /**
     * 仮会員登録画面表示
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function showVerifyRegister()
    {
        \RequestErrorServiceHelper::validateInsertError();
        return \View::make('front.member.verify_register');
    }

    /**
     * 仮会員登録実行
     * @param MemberVerifyRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function exeVerifyRegisterComplete(MemberVerifyRequest $request)
    {
        $member = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'email_verify_token' => base64_encode($request->email),
        ];

        // 会員登録処理
        Member::insert($member);

        \Mail::to($request->email)->send(new MemberVerifyMail($member));

        // リダイレクト時に渡さないキーを削除
        unset($member['password']);
        unset($member['email_verify_token']);
        return \Redirect::to('member/verify/complete')->with('member', $member);
    }

    /**
     * 仮会員登録完了
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function showVerifyRegisterComplete()
    {
        $member = session('member');
        return \View::make('front.member.verify_register_complete')->with('member', $member);
    }

    /**
     * 会員登録 表示
     */
    public function showRegister($email_token)
    {
        // 使用可能なトークンか
        if (!Member::where('email_verify_token', $email_token)->exists()) {
            return \View::make('front.member.register')->with('message', '無効なトークンです。');
        } else {
            $member = Member::where('email_verify_token', $email_token)->first();
            // 本登録済みのユーザーか
            if ($member->status == config('const.member_statuses.register')) {
                return \View::make('front.member.register')->with('message', 'すでに本登録されています。ログインして利用してください。');
            }
            // ステータスの更新
            $member->status = config('const.member_statuses.register');
            $member->email_verify_token = null;
            // 会員種別を登録
            $member->memberTypes()->attach([config('const.member_types.general')]);
            // 会員登録実行
            if ($member->save()) {
                // 登録完了メール
                \Mail::to($member->email)->send(new MemberRegisterCompleteMail($member));
                // ログイン
                \Auth::login($member);
                return \View::make('front.member.register')
                    ->with('name', $member->name);
            } else {
                return \View::make('front.member.register')->with('message', 'メール認証に失敗しました。再度、メールからリンクをクリックしてください。');
            }
        }
    }
}
