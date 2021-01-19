<?php

namespace App\Models;

use App\Traits\AuthorObservable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Member extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;
    use AuthorObservable;

    protected $guard = 'member';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'remember_token',
        'status',
        'email_verified',
        'email_verify_token',
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
     * 会員情報をIDで検索
     *
     * @param string $id
     * @return Member
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
     * 会員全件取得(削除以外)
     *
     * @return Member[]
     */
    public static function getAll()
    {
        $members = Member::select(
            'members.id',
            'members.name',
            'members.updated_by',
            'members.updated_at',
            'users.name as updated_name'
        )->leftjoin('users as users', function ($join) {
            $join->on('users.id', '=', 'members.updated_by');
        })->orderBy('members.updated_at', 'desc')
        ->paginate(config('pagination.items'));
        return $members;
    }

    /**
     * 会員登録処理
     *
     * @param $params
     * @return bool
     */
    public static function insert($params)
    {
        $result = false;
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
     * 会員情報 更新処理
     *
     * @param $id
     * @param $params
     * @return bool
     */
    public static function updateById($id, $params)
    {
        $result = false;
        if (isset($params)) {
            try {
                $result = \DB::transaction(function () use ($id, $params) {
                    $member = self::find($id);
                    $member->name = $params['name'];
                    $member->email = $params['email'];
                    if (isset($params['new_password'])) {
                        $member->password = bcrypt($params['new_password']);
                    }
                    return $member->save();
                });
            } catch (\Throwable $th) {
                \Log::error($th);
            }
        }
        return $result;
    }

    /**
     * @return mixed
     */
    public function update_at()
    {
        return $this->updated_at->format('Y/m/d h:m');
    }
}
