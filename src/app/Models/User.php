<?php

namespace App\Models;

use App\Traits\AuthorObservable;
use Crypt;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;
    use AuthorObservable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_type',
        'remember_token',
        'created_by',
        'updated_by',
        'deleted_by',
        'deleted_at',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * @return mixed
     */
    public function update_at()
    {
        return $this->updated_at->format('Y/m/d h:m');
    }

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    /**
     * パラメータの存在チェック
     * 存在しない場合はnullを挿入
     *
     * @param array $params
     * @return array $params
     */
    public static function paramsCheck($params)
    {
        $params['name']         = isset($params['name']) ? $params['name'] : null;
        $params['email']        = isset($params['email']) ? $params['email'] : null;
        $params['role_type']    = isset($params['role_type']) ? $params['role_type'] : null;
        $params['password']     = isset($params['password']) ? $params['password'] : null;
        $params['created_by']   = isset($params['created_by']) ? $params['created_by'] : null;
        $params['updated_by']   = isset($params['updated_by']) ? $params['updated_by'] : null;
        return $params;
    }

    /**
    * idをキーにユーザー情報を取得
    *
    * @param $id ユーザーid
    * @return |null|User ユーザ情報
    */
    public static function getById($id)
    {
        $result = null;
        $isId = isset($id) ? true : false;
        if ($isId) {
            $result = self::find($id);
        }
        return $result;
    }

    /**
     * ユーザー全件取得(削除以外)
     *
     * @return User[]
     */
    public static function getAll()
    {
        $users = User::select(
            'users.id',
            'users.name',
            'users.updated_by',
            'users.updated_at',
            'updated_by.name as updated_name'
        )->leftjoin('users as updated_by', function ($join) {
            $join->on('updated_by.id', '=', 'users.updated_by');
        })->orderBy('users.updated_at', 'desc')
        ->paginate(config('pagination.items'));
        return $users;
    }

    /**
        * ユーザ 登録処理
        *
        * @param $request
        * @return bool
        */
    public static function insert($params)
    {
        $result = false;
        $params = self::paramsCheck($params);
        if (isset($params)) {
            $result = self::create($params);
        }
        return $result;
    }

    /**
     * ユーザ 更新処理
     *
     * @param $inputs
     * @return bool
     */
    public static function updateById($id, $params)
    {
        $result = false;
        self::paramsCheck($params);
        if (isset($params)) {
            $user = self::find($id);
            if (isset($params['name'])) {
                $user->name = $params['name'];
            }
            if (isset($params['email'])) {
                $user->email = $params['email'];
            }
            if (isset($params['role_type'])) {
                $user->role_type = $params['role_type'];
            }
            if (isset($params['password'])) {
                $user->password = $params['password'];
            }
            if (isset($params['created_by'])) {
                $user->created_by = $params['created_by'];
            }
            if (isset($params['updated_by'])) {
                $user->updated_by = $params['updated_by'];
            }
            $result = $user->save();
        }
        return $result;
    }
}
