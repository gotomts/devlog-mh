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
        'markdown_content',
        'html_content',
        'status_id',
        'category_id',
        'created_by',
        'updated_by',
        'deleted_by',
        'deleted_at',
    ];

    /**
     * ユーザーとのリレーションを定義
     *
     * @return BelongsToMany
     */
    public function users()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * ステータスとのリレーションを定義
     *
     * @return BelongsToMany
     */
    public function statuses()
    {
        return $this->belongsTo(Status::class, 'status_id', 'id');
    }

    /**
     * カテゴリーとのリレーションを定義
     *
     * @return BelongsToMany
     */
    public function categories()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    /**
     * アイキャッチ画像とのリレーションを定義
     *
     * @return BelongsToMany
     */
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

    /**
     * IDで記事検索
     *
     * @param string $id
     * @return Post
     */
    public static function getById($id)
    {
        return self::findOrFail($id);
    }

    /**
     * URLをキーに記事を取得します
     *
     * @param  string $url
     * @param  Member|null   $member
     * @return Post   URLに該当する記事
     */
    public static function getByUrl($url, $member=null)
    {
        // URLから記事を取得
        $posts = self::where('url', '=', $url);

        // 記事に紐づく会員種別と会員の持つ会員種別が一致するかを確認する
        if (isset($member)) {
            // 会員の持つ会員種別のIDのみを配列として取得
            $memberTypesId = $member->memberTypes->pluck('id');
            //
            $posts->whereHas('memberTypes', function ($query) use ($memberTypesId) {
                $query->whereIn('id', $memberTypesId);
            });
        }

        return $posts->first();
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
        $posts = self::select(
            'posts.url',
            'posts.title',
            'posts.description',
            'posts.keyword',
            'posts.status_id',
            'posts.category_id',
            'posts.html_content',
            'posts.created_at',
            'categories.name as categories_name',
            'posts_images.url as posts_images_url',
            'posts_images.title as posts_images_title',
            'posts_images.alt as posts_images_alt',
        )->leftJoin('categories', 'categories.id', '=', 'posts.category_id')
        ->leftJoin('posts_images', 'posts_images.id', '=', 'posts.id')
        ->where('posts.status_id', '=', config('const.statuses.publishing'))
        ->paginate(config('pagination.items'));
        return $posts;
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
        // カテゴリを名前から検索
        $category = Category::where('name', '=', $categoryName)
            ->first();

        // カテゴリの記事検索
        $posts = self::select(
            'posts.url',
            'posts.title',
            'posts.description',
            'posts.keyword',
            'posts.status_id',
            'posts.category_id',
            'posts.html_content',
            'posts.created_at',
            'posts_images.url as posts_images_url',
            'posts_images.title as posts_images_title',
            'posts_images.alt as posts_images_alt',
        )
        ->leftJoin('posts_images', 'posts_images.id', '=', 'posts.id')
        ->where('posts.status_id', '=', $statusId)
        ->where('posts.category_id', '=', $category->id)
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
     * @param boolean  $isMemberLimitation
     * @return Post    前後ページの記事情報
     */
    public static function getPageLinkUrl($createdAt, $isPrev=false, $statusId)
    {
        $link =  self::where('status_id', '=', $statusId);

        if ($statusId === config('const.statuses.member_limitation')) {
            // 記事のステータスが会員限定の場合は会員が持つ会員種別と同じ記事情報のみを取得する
            $memberTypesId = \Auth::user()->memberTypes->pluck('id');
            $link->whereHas('memberTypes', function ($query) use ($memberTypesId) {
                $query->whereIn('id', $memberTypesId);
            });
        }

        if ($isPrev) {
            // 前ページ
            $link->where('created_at', '>', $createdAt)
                ->orderBy('created_at', 'asc');
        } else {
            // 次ページ
            $link->where('created_at', '<', $createdAt)
               ->orderBy('created_at', 'desc');
        }

        return $link->first();
    }

    /**
     * 会員限定公開記事を全件取得(削除以外)
     *
     * @param MemberTypes $memberTypes
     * @return Post[] 会員限定記事一覧
     */
    public static function getMemberLimitationAll()
    {
        // 会員種別からIDのみ種痘
        $memberTypesId = \Auth::user()->memberTypes->pluck('id');

        // 記事情報の取得
        $posts = self::with([
                'categories',
                'postImages',
            ])
            ->whereHas('statuses', function ($query) {
                $query->where('id', '=', config('const.statuses.member_limitation'));
            })
            ->whereHas('memberTypes', function ($query) use ($memberTypesId) {
                $query->whereIn('id', $memberTypesId);
            })
            ->orderBy('created_at', 'desc')
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

        // 会員種別はチェックの有無に関わらず一旦リセット
        $post->memberTypes()->detach();
        if (isset($params['member_types'])) {
            // 会員種別の選択がある場合は会員種別の更新処理を行う
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
