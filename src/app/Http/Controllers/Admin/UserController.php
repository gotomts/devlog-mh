<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\UserRequest;
use App\Logic\UserLogic;
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
        $users = UserLogic::getUsers(\IniHelper::get('DELETE_FLG', false, 'NO_ITEM'));
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
        $inputs['role']     = $request->role;
        $inputs['password'] = $request->password;
        \DB::beginTransaction();
        try {
            if (!UserLogic::insert($inputs)) {
                throw new \Throwable;
            }
        } catch (\Throwable $th) {
            \DB::rollback();
            \Log::warning($th);
            return redirect('admin/user')
                ->with('error', \MsgHelper::get('MSG_ERR_INSERT'));
        }
        \DB::commit();
        return redirect('admin/user')
            ->with('success', \MsgHelper::get('MSG_SUCCESS'))
            ->withInput();
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
            return back()->with('error', \MsgHelper::get('MSG_NODATA'));
        }
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
            return redirect('admin/user')
                ->with('error', \MsgHelper::get('MSG_ERR_UPDATE'));
        }
        \DB::commit();
        return redirect('admin/user')
            ->with('success', \MsgHelper::get('MSG_SUCCESS'));
    }
}
