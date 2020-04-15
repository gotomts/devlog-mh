<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\Images\ImageRequest;
use App\Logic\ImageLogic;
use App\Models\Image;
use Illuminate\Http\Request;

class ImageController extends WebBaseController
{
    /**
     * 画像一覧
     *
     * @return view
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
     * @param request $request
     * return void
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
     * @param request $request
     * @return view
     */
    public function showUpload(Request $request)
    {
        $images = [];
        $request->session()->flash('tmpPath', session('tmpPath'));
        $images['tmpPath'] = \PublicImageHelper::get(session('tmpPath'));
        return \View::make('admin.image.create')
            ->with('images', $images);
    }

    /**
     * 画像新規登録
     *
     * @param ImageRequest $request
     * @return void
     */
    public function exeCreate(ImageRequest $request)
    {
        $inputs = $request->all();
        // TODO:AWSS3アップロード後のURL取得作成
        // TODO:TMPファイルの一時ファイルを削除する
        $inputs['name'] = 'name';
        $inputs['url'] = 'url';
        \DB::beginTransaction();
        try {
            if (ImageLogic::insert($inputs)) {
                // TODO:insert成功時の処理を作成
            } else {
                // TODO:insert失敗時の処理を作成
            }
        } catch (\Throwable $th) {
            //throw $th;
        }
        \DB::commit();

        return \Redirect::to('admin/image');
    }
}
