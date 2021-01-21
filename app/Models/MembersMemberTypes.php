<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class MembersMemberTypes extends Pivot
{
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
