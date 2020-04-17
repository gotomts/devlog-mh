<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Image extends Model
{
    use SoftDeletes;

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
        $image = Image::orderBy('images.updated_at', 'desc')
            ->paginate(\IniHelper::get('PAGINATE', false, 'NUM'));
        return $image;
    }

    /**
     * 画像登録処理
     *
     * @param $inputs
     * @return bool
     */
    public static function insert($request, $attrs)
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
                \DB::transaction(function ($params) {
                    $result = Image::create($params);
                    return $result;
                });
            } catch (\Throwable $th) {
                \Log::warning(['Insert Fail/Throwable', $th]);
            }
        }
        return $result;
    }
}
