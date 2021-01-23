<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Admin\WebBaseController;
use App\Http\Requests\Front\Member\MemberVerifyRequest;
use App\Mail\MemberRegisterCompleteMail;
use App\Mail\MemberVerifyMail;
use App\Models\Member;
use Illuminate\Http\Request;

/**
 * コンテンツ側 認証コントローラ
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
        return \View::make('front.member.login');
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
        if (\Auth::guard('member')->attempt($input)) {
            return redirect('/member/index');
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
        \Auth::guard('member')->logout();
        return redirect('/');
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
