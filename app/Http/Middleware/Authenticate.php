<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * 未ログインのユーザーが認証が必要なURLへアクセスした際のリダイレクト先を定義
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string
     */
    protected function redirectTo($request)
    {
        $path = $request->path();
        $resultPath = strpos($path, 'admin');
        if ($resultPath === 0) {
            // 管理画面
            $url = 'admin';
        } else {
            // 管理画面以外
            $url = 'member';
        }

        if (! $request->expectsJson()) {
            return url($url);
        }
    }
}
