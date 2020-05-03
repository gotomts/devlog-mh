<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PostImage extends Model
{
    use SoftDeletes;

    protected $table = 'posts_images';

    protected $fillable = [
        'name',
        'url',
        'title',
        'alt',
    ];

    /**
     * モデルのタイムスタンプを更新しない
     *
     * @var bool
     */
    public $timestamps = false;
}
