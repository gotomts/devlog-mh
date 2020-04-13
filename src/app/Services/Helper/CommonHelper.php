<?php
/**
 * 共通処理ヘルパー
 *
 * 様々な箇所で使用するような処理を入れる
 * @author M.Goto
 */
namespace App\Services\Helper;

use Carbon\Carbon;

class CommonHelper
{
    /**
     * ログインチェック
     *
     * ログインしていない場合はログイン画面にリダイレクトする
     */
    public function checkLogin()
    {
        // セッション切れ
        if (!\Auth::check()) {
            return redirect('login')
                ->with('error', \MsgHelper::get('MSG_ERR_SESSION'));
        }
    }

    public function getNow()
    {
        return new Carbon();
    }
}
