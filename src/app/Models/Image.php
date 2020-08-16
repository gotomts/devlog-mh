<?php

namespace App\Models;

use App\Traits\AuthorObservable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Image extends Model
{
    use SoftDeletes;
    use AuthorObservable;

    protected $table = 'images';

    protected $fillable = [
        'url',
        'title',
        'alt',
        'created_by',
        'updated_by',
        'deleted_by',
        'deleted_at',
    ];

    /**
     * 画像全件取得(削除以外)
     *
     * @return Image[]
     */
    public static function getAll()
    {
        $image = self::orderBy('images.updated_at', 'desc')
            ->paginate(config('pagination.items'));
        return $image;
    }

    public static function getById($id)
    {
        return self::find($id);
    }

    /**
     * 画像登録処理
     *
     * @param $request
     * @param $attrs
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
     * 画像更新処理
     *
     * @param request $request
     * @return bool
     */
    public static function updateById($id, $params)
    {
        $result = false;
        if (isset($params)) {
            try {
                $result = \DB::transaction(function () use ($id, $params) {
                    $image = self::find($id);
                    $image->title      = $params['title'];
                    $image->alt        = $params['alt'];
                    $image->updated_by = $params['updated_by'];
                    return $image->save();
                });
            } catch (\Throwable $th) {
                \Log::error($th);
            }
        }
        return $result;
    }
}
