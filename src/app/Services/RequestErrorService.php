<?php

namespace App\Services;

/**
 * リクエストエラーサービス
 *
 * @author M.Goto
 */
class RequestErrorService
{
    /**
     * 登録リクエストバリデーションエラー
     */
    public static function validateInsertError()
    {
        if (session('errors')) {
            flash(config('messages.error.insert'))->error();
        }
    }

    /**
     * 更新リクエストバリデーションエラー
     */
    public static function validateUpdateError()
    {
        if (session('errors')) {
            flash(config('messages.error.update'))->error();
        }
    }
}
