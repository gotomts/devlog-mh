<?php

namespace App\Logic;

use App\Models\Image;

class ImageLogic
{

    /**
     * 画像全件取得(削除以外)
     *
     * @return Image[]
     */
    public static function getImages()
    {
        $image = Image::select(
            'images.id',
            'images.name',
            'images.updated_by',
            'images.updated_at',
        )->orderBy('images.updated_at', 'desc')
        ->paginate(\IniHelper::get('PAGINATE', false, 'NUM'));
        return $image;
    }
}
