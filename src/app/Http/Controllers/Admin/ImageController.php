<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Logic\ImageLogic;
use App\Models\Image;
use Illuminate\Http\Request;

class ImageController extends WebBaseController
{
    /**
     * 画像一覧
     *
     * return View
     */
    public function showList()
    {
        $images = ImageLogic::getImages();
        return \View::make('admin.image.list')
            ->with('images', $images);
    }

    /**
     * 画像アップロード
     *
     * return View
     */
    public function exeUpload(Request $request)
    {
        $file = $request->file('uploadfile');
        $tmpPath = \Storage::disk('public')->putFile(\IniHelper::get('IMAGES_PATH', false, 'TMP'), $file);
        $request->session()->flash('tmpPath', $tmpPath);
        return \Redirect::to('admin/image/upload');
    }

    /**
     * アップロードプレビュー・編集
     *
     * @return void
     */
    public function showUpload(Request $request)
    {
        $images = [];
        $request->session()->flash('tmpPath', session('tmpPath'));
        $images['tmpPath'] = \PublicImageHelper::get(session('tmpPath'));
        return \View::make('admin.image.create')
            ->with('images', $images);
    }
}
