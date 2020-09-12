<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\Profile\ProfileRequest;
use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends WebBaseController
{
    /** 編集トップ */
    private const TOP = 'admin/profile/edit';

    /**
     * プロフィール編集 表示処理
     *
     * @return view
     */
    public function showEdit()
    {
        $user = User::getById(\Auth::guard()->user()->id);
        return \View::make('admin.profile.edit')
            ->with('user', $user);
    }

    /**
     * プロフィール編集 更新処理
     *
     * @param ProfileRequest $request
     * @return void
     */
    public function exeEdit(ProfileRequest $request)
    {
        // 更新処理
        if (User::updateByProfile($request)) {
            flash(config('messages.common.success'))->success();
        } else {
            flash(config('messages.exception.update'))->error();
            return redirect(self::TOP);
        }
        return redirect(self::TOP);
    }
}
