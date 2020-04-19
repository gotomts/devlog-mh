<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\UserRequest;
use App\Logic\UserLogic;
use App\Services\RequestErrorService;
use Illuminate\Http\Request;

class UserController extends WebBaseController
{
    /**
     * ユーザ管理 一覧
     *
     * return View
     */
    public function showList()
    {
        $users = UserLogic::getUsers();
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
        // フォームから値を取得
        $inputs['name']     = $request->name;
        $inputs['email']    = $request->email;
        $inputs['role_type']     = $request->role_type;
        $inputs['password'] = $request->password;
        \DB::beginTransaction();
        try {
            if (!UserLogic::insert($inputs)) {
                throw new \Throwable;
            }
        } catch (\Throwable $th) {
            \DB::rollback();
            \Log::warning($th);
            flash(config('messages.exception.insert'))->error();
            return redirect('admin/user');
        }
        \DB::commit();
        flash(config('messages.common.success'))->success();
        return redirect('admin/user');
    }

    /**
     * ユーザ管理 編集画面表示
     *
     * @param $id ユーザーID
     * return View
     */
    public function showEdit($id=null)
    {
        $user = UserLogic::getUserById($id);
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
        $inputs = $request->all();
        \DB::beginTransaction();
        try {
            if (!UserLogic::update($id, $inputs)) {
                throw new \Throwable;
            }
        } catch (\Throwable $th) {
            \DB::rollback();
            \Log::warning($th);
            flash(config('messages.exception.update'))->error();
            return redirect('admin/user');
        }
        \DB::commit();
        flash(config('messages.common.success'))->success();
        return redirect('admin/user');
    }
}
