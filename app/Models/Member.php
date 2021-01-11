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
     * @return mixed
     */
    public function update_at()
    {
        return $this->updated_at->format('Y/m/d h:m');
    }
}
