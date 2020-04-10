<?php

namespace App\Logic;

use App\User;
use Illuminate\Support\Facades\Crypt;

class UserLogic
{

    /**
     * Undocumented function
     *
     * @param [type] $inputs
     * @return void
     */
    public static function check($inputs) {
        $inputRequires = [];
        $inputRequires['name']      = isset($inputs['name']) ? true : false;
        $inputRequires['email']     = isset($inputs['email']) ? true : false;
        $inputRequires['role']      = isset($inputs['role']) ? true : false;
        $inputRequires['password']  = isset($inputs['password']) ? true : false;
        $check;
        foreach ($inputRequires as $input) {
            $check = $input;
        }
        if ($check) {
            return true;
        }
        return false;
    }

    /**
    * idをキーにユーザー情報を取得
    *
    * @param $id ユーザーid
    * @return |null|User ユーザ情報
    */
    public static function getUserById($id)
    {
        $result = null;
        $isId = isset($id) ? true : false;
        if ($isId) {
            $result = User::find($id);
        }
        return $result;
    }

    /**
     * ユーザー全件取得
     *
     * @param  int $delete_flg
     * @return User[]
     */
    public static function getUsers($delete_flg)
    {
        $users = User::select(
                'users.id',
                'users.name',
                'users.updated_at',
                'users.delete_flg',
                'updater.name as updater'
            )
            ->leftjoin('users as updater', function($join) {
                $join->on('users.user_id', '=', 'updater.id');
            })
            ->where('users.delete_flg', '=', $delete_flg)
            ->orderBy('users.updated_at', 'desc')
            ->paginate(config('const.Paginate.NUM'));
        return $users;
    }

    /**
        * カテゴリー登録処理
        *
        * @param $inputs
        * @return bool
        */
    public static function insert($inputs)
    {
        if (self::check($inputs)) {
            $user = new User;
            $user->name     = $inputs['name'];
            $user->email    = $inputs['email'];
            $user->role     = $inputs['role'];
            $user->password = Crypt::encrypt($inputs['password']);
            $user->user_id = \Auth::id();
            return $user->save();
        }
        return false;
    }
//
//    /**
//     * カテゴリー 更新処理
//     *
//     * @param $inputs
//     * @return bool
//     */
//    public static function update($inputs)
//    {
//        $id = isset($inputs['id']) ? $inputs['id'] : false;
//        $categoryName = isset($inputs['category_name']) ? $inputs['category_name'] : false;
//        if ($id && $categoryName) {
//            $category = Category::find($id);
//            $category->category_name = $categoryName;
//            $category->user_id = \Auth::id();
//            return $category->save();
//        }
//        return false;
//    }
}
