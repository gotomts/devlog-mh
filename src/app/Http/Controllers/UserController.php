<?php

namespace App\Http\Controllers;

use App\Enums\UserRoleType;
use App\Http\Request\UserRequest;
use App\Http\Traits\ArrayConvertion;
use App\Logic\UserLogic;
use Illuminate\Http\Request;

class UserController extends WebBaseController
{

    use ArrayConvertion;

    /**
     * ユーザ管理 一覧
     *
     * return View
     */
    public function showList()
    {
        $users = UserLogic::getUsers(config('const.DELETE_FLG.none'));
        return \View::make('user.list')
            ->with('users', $users);
    }

    /**
     * ユーザ管理 作成
     *
     * return View
     */
    public function showCreate()
    {
        $roleTypes = UserRoleType::values();
        $roles = $this->enumToArray($roleTypes);
        return \View::make('user.create')
            ->with('roles', $roles);
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
            // ログイン確認
            if (\Auth::check()) {
                $result = UserLogic::insert($inputs);
                \DB::commit();
                return redirect('mh-login/user')
                    ->with('success', config('messages.success'))
                    ->withInput();
            }
        } catch (\Throwable $e) {
            \DB::rollback();
            return redirect('mh-login/user')
                ->with('error', config('messages.error.insert'));
        }
        \DB::commit();
    }

    /**
     * ユーザ管理 編集画面表示
     *
     * @param Request $request
     * return View
     */
    public function showEdit(Request $request)
    {
        $inputs['id'] = $request->id;
        $user = UserLogic::getUserById($inputs['id']);
        $roleTypes = UserRoleType::values();
        $roles = $this->enumToArray($roleTypes);
        // セッション切れ
        if (!\Auth::check()) {
            return redirect('login')
                ->with('error', 'messages.error.session');
        }
        // カテゴリーが見つからない場合
        if (is_null($user)) {
            return back()->with('error', config('messages.nodata'));
        }
        return \View::make('user.edit')
            ->with('user', $user)
            ->with('roles', $roles);
    }


}
