<?php

namespace App\Models;

use Crypt;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;

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
    public static function insert($request)
    {
        $result = false;
        $params = $request->all();
        $params['password'] = bcrypt($params['password']);
        if (isset($params)) {
            try {
                $result = \DB::transaction(function () use ($params) {
                    return self::create($params);
                });
            } catch (\Throwable $th) {
                \Log::error($th);
            }
        }
        return $result;
    }

    /**
     * ユーザ 更新処理
     *
     * @param $inputs
     * @return bool
     */
    public static function updateById($id, $request)
    {
        $result = false;
        $params = $request->all();
        if (isset($params)) {
            try {
                $result = \DB::transaction(function () use ($id, $params) {
                    $user = self::find($id);
                    $user->name      = $params['name'];
                    $user->email     = $params['email'];
                    $user->role_type = $params['role_type'];
                    $user->password  = bcrypt($params['password']);
                    return $user->save();
                });
            } catch (\Throwable $th) {
                \Log::error($th);
            }
        }
        return $result;
    }

    /**
     * プロフィール更新処理
     *
     * @param Request $request
     * @return bool
     */
    public static function updateByProfile($request)
    {
        $result = false;
        $params = $request->all();
        if (isset($params)) {
            try {
                $result = \DB::transaction(function () use ($params) {
                    $user = self::find(\Auth::guard()->user()->id);
                    $user->name      = $params['name'];
                    $user->email     = $params['email'];
                    if (isset($params['password'])) {
                        $user->password  = bcrypt($params['password']);
                    }
                    return $user->save();
                });
            } catch (\Throwable $th) {
                \Log::error($th);
            }
        }
        return $result;
    }
}
