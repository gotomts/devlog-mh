<?php

namespace App\Models;

use App\Traits\AuthorObservable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;
    use AuthorObservable;

    protected $table = 'categories';

    protected $guarded = array('id');

    public $timestamps = true;

    protected $fillable = [
        'name',
        'created_by',
        'updated_by',
        'deleted_by',
        'deleted_at',
    ];

    protected $dates = [
        'updated_at',
    ];

    /**
     * @return mixed
     */
    public function update_at()
    {
        return $this->updated_at->format('Y/m/d h:m');
    }

    /**
     * idをキーにカテゴリー情報を取得
     *
     * @param $id カテゴリーID
     * @return |null|Category カテゴリー情報
     */
    public static function getById($id)
    {
        $result = null;
        $isId = isset($id) ? true : false;
        if ($isId) {
            $result = self::find($id);
        }
        return $result;
    }

    /**
     * カテゴリー全件取得(削除以外)
     *
     * @return Category[]
     */
    public static function getAll()
    {
        $category = self::select(
            'categories.id',
            'categories.name',
            'categories.updated_by',
            'categories.updated_at',
            'updated_by.name as updated_name'
        )->leftjoin('users as updated_by', function ($join) {
            $join->on('updated_by.id', '=', 'categories.updated_by');
        })->orderBy('categories.updated_at', 'desc')
        ->paginate(config('pagination.items'));
        return $category;
    }

    /**
     * 投稿記事の存在するカテゴリーを取得
     *
     * @return Category カテゴリー情報
     */
    public static function getPostCategory()
    {
        $category = self::distinct()
        ->select(
            'categories.id',
            'categories.name'
        )->join('posts', function ($join) {
            $join->on('posts.category_id', '=', 'categories.id');
        })->orderBy('categories.id', 'asc')
        ->get();
        return $category;
    }

    /**
     * カテゴリー登録処理
     *
     * @param $inputs
     * @return bool
     */
    public static function insert($params)
    {
        $result = false;
        if (isset($params)) {
            try {
                $result = \DB::transaction(function () use ($params) {
                    return self::create($params);
                });
            } catch (\Throwable $th) {
                \Log::error($th);
            }
        }
        return $result;
    }

    /**
     * カテゴリー 更新処理
     *
     * @param $inputs
     * @return bool
     */
    public static function updateById($id, $params)
    {
        $result = false;
        if (isset($params)) {
            try {
                $result = \DB::transaction(function () use ($id, $params) {
                    $category = self::find($id);
                    $category->name      = $params['name'];
                    return $category->save();
                });
            } catch (\Throwable $th) {
                \Log::error($th);
            }
        }
        return $result;
    }
}
