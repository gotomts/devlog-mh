<?php

namespace App\Models;

use App\Traits\AuthorObservable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use SoftDeletes;
    use AuthorObservable;

    protected $table = 'posts';

    protected $fillable = [
        'url',
        'title',
        'description',
        'keyword',
        'content',
        'post_image_id',
        'status_id',
        'category_id',
        'created_by',
        'updated_by',
        'deleted_by',
        'deleted_at',
    ];

    public function User()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function statuses()
    {
        return $this->belongsTo(Status::class, 'status_id');
    }

    public function categories()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function postImages()
    {
        return $this->hasOne(PostImage::class);
    }

    /**
     * 記事全件取得(削除以外)
     *
     * @return Post[]
     */
    public static function getAll()
    {
        $posts = self::orderBy('posts.updated_at', 'desc')
        ->paginate(config('pagination.items'));
        return $posts;
    }

    /**
     * 記事 登録処理
     *
     * @param  $request
     * @return bool
     */
    public static function insert($request, $attrs)
    {
        $result = false;
        $params = $request->all();
        $attrs += isset($attrs) ? $attrs : null;
        if (isset($params)) {
            $result = self::create($params);
            return $result;
        }
        return $result;
    }

    public static function insertWithPostImage($request, $attrs)
    {
        $result = false;
        $params = $request->all();
        $attrs += isset($attrs) ? $attrs : null;
        $postImagesAttrs = [];
        $postImagesAttrs += [
            'url'  => isset($attrs['post_images_url']) ? $attrs['post_images_url']  : null,
            'name' => isset($attrs['post_images_name']) ? $attrs['post_images_name'] : null,
            'title' => isset($attrs['post_images_name']) ? $attrs['post_images_name'] : null,
            'alt' => isset($attrs['post_images_name']) ? $attrs['post_images_name'] : null,
        ];
        if (isset($params)) {
            $post = self::create($params);
            $postImage = $post->postImages()->create($postImagesAttrs);
            if (isset($post) && isset($postImage)) {
                $result = true;
            }
            return $result;
        }
        return $result;
    }
}
