<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * ログイン後のリダイレクト先
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        switch ($guard) {
            case 'admin':
                $redirectPath = '/admin/index';
                break;
            case 'member':
                $redirectPath = '/member/index';
                break;
            default:
                $redirectPath = '/';
                break;
        }
        if (Auth::guard($guard)->check()) {
            return redirect($redirectPath);
        }

        return $next($request);
    }
}
