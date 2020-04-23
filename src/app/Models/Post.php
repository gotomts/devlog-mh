<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use SoftDeletes;

    protected $table = 'posts';

    protected $fillable = [
        'url',
        'title',
        'description',
        'keyword',
        'content',
        'created_by',
        'updated_by',
        'deleted_by',
        'deleted_at',
    ];

    /**
     * 記事全件取得(削除以外)
     *
     * @return Post[]
     */
    public static function getAll()
    {
        $posts = self::select(
            'posts.id',
            'posts.url',
            'posts.title',
            'posts.description',
            'posts.keyword',
            'posts.content',
            'posts.updated_by',
            'posts.updated_at',
            'updated_by.name as updated_name'
        )->leftjoin('users as updated_by', function ($join) {
            $join->on('updated_by.id', '=', 'posts.updated_by');
        })->orderBy('posts.updated_at', 'desc')
        ->paginate(config('pagination.items'));
        return $posts;
    }
}
