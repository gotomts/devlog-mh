<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;

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
            'users.name as user_name'
        )->leftjoin('users', function ($join) {
            $join->on('users.id', '=', 'categories.updated_by');
        })->orderBy('categories.updated_at', 'desc')
        ->paginate(config('pagination.items'));
        return $category;
    }

    /**
     * カテゴリー全件取得(削除済み)
     *
     * @return Category[]
     */
    public static function getDeletedAll()
    {
        $category = self::onlyTrashed()->select(
            'categories.id',
            'categories.name',
            'categories.deleted_by',
            'categories.deleted_at',
            'users.name as user_name'
        )->leftjoin('users', function ($join) {
            $join->on('users.id', '=', 'categories.deleted_by');
        })->orderBy('categories.deleted_at', 'desc')
        ->paginate(config('pagination.items'));
        return $category;
    }

    /**
     * カテゴリー登録処理
     *
     * @param $inputs
     * @return bool
     */
    public static function insert($request, $attrs = [])
    {
        $result = false;
        $params = $request->all();
        $attrs  = $attrs + [
            'created_by' => \Auth::user()->id,
            'updated_by' => \Auth::user()->id,
        ];
        if (isset($params)) {
            $params = $params + $attrs;
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
    public static function updateById($id, $request, $attrs = [])
    {
        $result = false;
        $params = $request->all();
        if (isset($params)) {
            $params = $params + $attrs;
            try {
                $result = \DB::transaction(function () use ($id, $params) {
                    $category = self::find($id);
                    $category->name      = $params['name'];
                    $category->updated_by = \Auth::user()->id;
                    return $category->save();
                });
            } catch (\Throwable $th) {
                \Log::error($th);
            }
        }
        return $result;
    }
}
