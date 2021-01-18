<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MembersMemberTypes extends Model
{
    protected $table = 'members_member_types';

    protected $fillable = [
        'members_id',
        'member_types_id',
    ];

    /**
     * モデルのタイムスタンプを更新しない
     *
     * @var bool
     */
    public $timestamps = false;
}
