<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\User\UserRequest;
use App\Models\User;
use Exception;

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
        \RequestErrorServiceHelper::validateInsertError();
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
        $params = $request->all();
        \DB::beginTransaction();
        try {
            $result = User::insert($params);
            if (isset($result)) {
                flash(config('messages.common.success'))->success();
            } else {
                throw new Exception(config('messages.exception.insert'));
            }
        } catch (\Throwable $th) {
            \DB::rollback();
            \Log::error($th);
            flash(config('messages.exception.insert'))->error();
            return redirect(self::LIST);
        }
        \DB::commit();
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
        \RequestErrorServiceHelper::validateUpdateError();
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
        $params = $request->all();
        \DB::beginTransaction();
        try {
            $result = User::updateById($id, $params);
            if (isset($result)) {
                flash(config('messages.common.success'))->success();
            } else {
                throw new Exception(config('messages.exception.update'));
            }
        } catch (\Throwable $th) {
            \DB::rollback();
            \Log::error($th);
            flash(config('messages.exception.update'))->error();
            return redirect(self::LIST);
        }
        \DB::commit();
        return redirect(self::LIST);
    }
}
