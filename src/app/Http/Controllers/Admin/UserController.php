<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Services\RequestErrorService;
use Illuminate\Http\Request;

class UserController extends WebBaseController
{

    /** 一覧 */
    private const LIST = 'admin/user';

    /**
     * ユーザ管理 一覧
     *
     * return View
     */
    public function showList()
    {
        $users = User::getAll();
        return \View::make('admin.user.list')
            ->with('users', $users);
    }

    /**
     * ユーザ管理 作成
     *
     * return View
     */
    public function showCreate()
    {
        RequestErrorService::validateInsertError();
        return \View::make('admin.user.create');
    }

    /**
     * ユーザー管理 登録処理
     *
     * @param UserRequest $request
     * @return void
     */
    public function exeCreate(UserRequest $request)
    {
        if (User::insert($request)) {
            flash(config('messages.common.success'))->success();
        } else {
            flash(config('messages.exception.insert'))->error();
            return redirect(self::LIST);
        }
        return redirect(self::LIST);
    }

    /**
     * ユーザ管理 編集画面表示
     *
     * @param $id ユーザーID
     * return View
     */
    public function showEdit($id=null)
    {
        $user = User::getById($id);
        // ユーザーが見つからない場合
        if (is_null($user)) {
            return back()->with('error', config('messages.common.nodata'));
        }
        RequestErrorService::validateUpdateError();
        return \View::make('admin.user.edit')
            ->with('user', $user);
    }

    /**
     * Undocumented function
     *
     * @param UserRequest $request
     * @return void
     */
    public function exeEdit(UserRequest $request, $id=null)
    {
        // 更新処理
        if (User::updateById($id, $request)) {
            flash(config('messages.common.success'))->success();
        } else {
            flash(config('messages.exception.update'))->error();
            return redirect(self::LIST);
        }
        return redirect(self::LIST);
    }
}
