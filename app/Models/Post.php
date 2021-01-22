<?php

namespace App\Models;

use App\Traits\AuthorObservable;
use App\Models\MemberTypes;
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
        'markdown_content',
        'html_content',
        'status_id',
        'category_id',
        'created_by',
        'updated_by',
        'deleted_by',
        'deleted_at',
    ];

    public function user()
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
     * 会員種別とのリレーションを定義
     *
     * @return BelongsToMany
     */
    public function memberTypes()
    {
        return $this
            ->belongsToMany(
                MemberTypes::class,
                'posts_member_types',
                'posts_id',
                'member_types_id'
            );
    }

    public static function getById($id)
    {
        return self::findOrFail($id);
    }

    /**
     * URLをキーに記事を取得します
     *
     * @param  $url url
     * @return Post URLに該当する記事
     */
    public static function getByUrl($url)
    {
        return self::where('url', '=', $url)->first();
    }

    /**
     * 記事全件取得(削除以外)
     *
     * @return Post[] 記事一覧
     */
    public static function getAll()
    {
        $posts = self::orderBy('posts.updated_at', 'desc')
        ->paginate(config('pagination.items'));
        return $posts;
    }

    /**
     * 公開記事を全件取得(削除以外)
     *
     * @return Post[] 公開記事一覧
     */
    public static function getPublishingAll()
    {
        $posts = self::where('status_id', '=', config('const.statuses.publishing'))
            ->orderBy('posts.created_at', 'desc')
            ->paginate(config('pagination.items'));
        return $posts;
    }

    /**
     * 会員限定公開記事を全件取得(削除以外)
     *
     * @return Post[] 会員限定記事一覧
     */
    public static function getMemberLimitationAll()
    {
        $posts = self::where('status_id', '=', config('const.statuses.member_limitation'))
            ->orderBy('posts.created_at', 'desc')
            ->paginate(config('pagination.items'));
        return $posts;
    }

    /**
     * 前後ページのリンクを取得
     *
     * @param int|null $id
     * @param boolean  $isPrev
     * @param int      $statusId
     * @return Post    前後ページの記事情報
     */
    public static function getPageLinkUrl($createdAt, $isPrev=false, $statusId)
    {
        $link =  self::where('status_id', '=', $statusId);

        if ($isPrev) {
            $link->where('created_at', '>', $createdAt)
                ->orderBy('created_at', 'asc');
        } else {
            $link->where('created_at', '<', $createdAt)
               ->orderBy('created_at', 'desc');
        }
        return $link->first();
    }

    /**
     * カテゴリーを絞り込んだ記事を取得
     *
     * @param string $categoryName
     * @param string $statusId
     * @return Post[] カテゴリーで絞り込んだ記事一覧
     */
    public static function getPostCategoryAll($categoryName, $statusId)
    {
        $category = Category::where('name', '=', $categoryName)
            ->first();

        $posts = self::where('category_id', '=', $category->id)
            ->where('status_id', '=', $statusId)
            ->orderBy('posts.created_at', 'desc')
            ->paginate(config('pagination.items'));
        return $posts;
    }

    /**
     * 記事 登録処理
     *
     * @param  $request
     * @return bool
     */
    public static function insert($params)
    {
        $result = false;

        // 記事モデルをインスタンス化
        $post = new Post();

        if (isset($params)) {
            $post->title       = $params['title'];
            $post->url         = $params['url'];
            $post->keyword     = $params['keyword'];
            $post->description = $params['description'];
            $post->category_id = $params['category_id'];
            $post->status_id   = $params['status_id'];
            $post->markdown_content = $params['markdown_content'];
            $post->html_content     = $params['html_content'];
            $result = $post->save();
        }

        if (isset($params['member_types'])) {
            // 会員種別の選択がある場合は会員種別の登録処理を行う
            $post->memberTypes()->attach($params['member_types']);
        }

        return $result;
    }

    /**
     * 記事 登録処理 画像あり
     *
     * @param  $request
     * @return bool
     */
    public static function insertWithPostImage($params)
    {
        $result = false;
        $params += isset($params) ? $params : null;
        $postImagesAttrs = [];
        $postImagesAttrs += [
            'url'  => isset($params['post_images_url']) ? $params['post_images_url']  : null,
            'name' => isset($params['post_images_name']) ? $params['post_images_name'] : null,
            'title' => isset($params['post_images_name']) ? $params['post_images_name'] : null,
            'alt' => isset($params['post_images_name']) ? $params['post_images_name'] : null,
        ];

        // 記事モデルをインスタンス化
        $post = new Post();

        if (isset($params)) {
            // 記事情報の登録
            $post->title       = $params['title'];
            $post->url         = $params['url'];
            $post->keyword     = $params['keyword'];
            $post->description = $params['description'];
            $post->category_id = $params['category_id'];
            $post->status_id   = $params['status_id'];
            $post->markdown_content = $params['markdown_content'];
            $post->html_content     = $params['html_content'];
            $result = $post->save();
            // 画像の登録
            $postImage = $post->postImages()->create($postImagesAttrs);
            if (isset($post) && isset($postImage)) {
                $result = true;
            }
        }

        if (isset($params['member_types'])) {
            // 会員種別の選択がある場合は会員種別の登録処理を行う
            $post->memberTypes()->attach($params['member_types']);
        }

        return $result;
    }

    /**
     * カテゴリー 更新処理
     *
     * @param $inputs
     * @return bool
     */
    public static function updateById($id, $request)
    {
        // 結果の変数を初期化
        $result = false;

        // リクエストの値をすべて取得
        $params = $request->all();

        // 記事情報を取得
        $post = self::findOrFail($id);

        // 会員種別はチェックの有無に関わらず一旦リセット
        $post->memberTypes()->detach();
        if (isset($params['member_types'])) {
            // 会員種別の選択がある場合は会員種別の更新処理を行う
            $post->memberTypes()->attach($params['member_types']);
        }

        if (isset($params)) {
            $post->title       = $params['title'];
            $post->url         = $params['url'];
            $post->keyword     = $params['keyword'];
            $post->description = $params['description'];
            $post->category_id = $params['category_id'];
            $post->status_id   = $params['status_id'];
            $post->markdown_content = $params['markdown_content'];
            $post->html_content     = $params['html_content'];
            return $post->save();
        }
        return $result;
    }

    /**
     * カテゴリー 更新処理
     *
     * @param $inputs
     * @return bool
     */
    public static function updateByIdWithPostImage($id, $request, $attrs)
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
            // 記事情報の取得
            $post = self::findOrFail($id);
            // 記事情報の更新
            $post->title       = $params['title'];
            $post->url         = $params['url'];
            $post->keyword     = $params['keyword'];
            $post->description = $params['description'];
            $post->category_id = $params['category_id'];
            $post->status_id   = $params['status_id'];
            $post->markdown_content = $params['markdown_content'];
            $post->html_content     = $params['html_content'];
            $resultPost = $post->save();
            // アイキャッチ画像の更新
            $postImage = PostImage::firstWhere('post_id', $id);
            if (is_null($postImage)) {
                $resultPostImage = $post->postImages()->create($postImagesAttrs);
            } else {
                $postImage->url   = $postImagesAttrs['url'];
                $postImage->name  = $postImagesAttrs['name'];
                $postImage->title = $postImagesAttrs['title'];
                $postImage->alt   = $postImagesAttrs['alt'];
                $resultPostImage  = $postImage->save();
            }
            if ($resultPost && $resultPostImage) {
                $result = true;
            }
        }

        // 会員種別はチェックの有無に関わらず一旦リセット
        $post->memberTypes()->detach();
        if (isset($params['member_types'])) {
            // 会員種別の選択がある場合は会員種別の更新処理を行う
            $post->memberTypes()->attach($params['member_types']);
        }

        return $result;
    }
}
