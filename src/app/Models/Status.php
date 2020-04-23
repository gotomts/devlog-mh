<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    protected $table = 'statuses';

    protected $fillable = [
        'name',
    ];

    /**
     * モデルのタイムスタンプを更新しない
     *
     * @var bool
     */
    public $timestamps = false;
}
