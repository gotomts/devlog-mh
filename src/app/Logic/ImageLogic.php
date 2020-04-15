<?php

namespace App\Logic;

use App\Models\Image;

class ImageLogic
{
    private static function check($inputs)
    {
        $inputRequires = [];
        $inputRequires['name']  = isset($inputs['name']) ? true : false;
        $inputRequires['url']   = isset($inputs['url']) ? true : false;
        $inputRequires['title'] = isset($inputs['title']) ? true : false;
        $inputRequires['alt']   = isset($inputs['alt']) ? true : false;
        $check = null;
        foreach ($inputRequires as $input) {
            $check = $input;
        }
        if ($check) {
            return true;
        }
        return false;
    }

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

    /**
     * 画像登録処理
     *
     * @param $inputs
     * @return bool
     */
    public static function insert($inputs)
    {
        if (self::check($inputs)) {
            $image = new Image;
            $image->name  = $inputs['name'];
            $image->url   = $inputs['url'];
            $image->title = $inputs['title'];
            $image->alt   = $inputs['alt'];
            $image->created_by = \Auth::user()->id;
            $image->updated_by = \Auth::user()->id;
            return $image->save();
        }
        return false;
    }
}
