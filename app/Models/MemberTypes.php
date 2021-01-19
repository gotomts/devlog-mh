<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MemberTypes extends Model
{
    protected $table = 'member_types';

    protected $fillable = [
        'name',
    ];

    /**
     * モデルのタイムスタンプを更新しない
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * 会員種別名を種痘
     *
     * @return array
     */
    public static function getAll()
    {
        return self::all();
    }
}
