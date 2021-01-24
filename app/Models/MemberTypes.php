<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Member;
use App\Models\Post;

class MemberTypes extends Model
{
    protected $table = 'member_types';

    /**
     * 親モデルのタイムスタンプ更新
     */
    protected $touches = [
        'posts',
        'members',
    ];

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
     * Memberモデルとのリレーションを定義
     *
     * @return BelongsToMany
     */
    public function members()
    {
        return $this
            ->belongsToMany(
                Member::class,
                'members_member_types',
                'member_types_id',
                'members_id'
            );
    }

    /**
     * Postモデルとのリレーションを定義
     *
     * @return BelongsToMany
     */
    public function posts()
    {
        return $this
            ->belongsToMany(
                Post::class,
                'posts_member_types',
                'member_types_id',
                'posts_id'
            );
    }

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
