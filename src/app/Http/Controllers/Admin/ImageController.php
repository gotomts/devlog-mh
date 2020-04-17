<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\Images\ImageRequest;
use App\Models\Image;
use App\Services\AwsS3FIleUploadService;
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
        $images = Image::getAll();
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
        // TODO:バリデーション作成
        $file = $request->file('uploadfile');
        $tmpPath = \Storage::disk('public')->putFile(config('storage.images_path.tmp'), $file);
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
        // TODO:リロード対策
        $images = [];
        session()->flash('tmpPath', session('tmpPath'));
        $images['tmpPath'] = \Storage::disk('public')->url(session('tmpPath'));
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
        $file = \Storage::disk('public')->path(session('tmpPath'));
        $path = AwsS3FIleUploadService::upload($file);
        // アップロード確認
        if (AwsS3FIleUploadService::checkUpload($path)) {
            // アップロード先URL取得
            $attrs['url'] = config('app.s3_url').$path;
            // 一時ファイルを削除
            \Storage::disk('public')->delete(session('tmpPath'));
        } else {
            // 一時ファイルを削除
            \Storage::disk('public')->delete(session('tmpPath'));
            flash(config('messages.error.file_upload'))->error();
            \Log::warning(['Upload File Fail', 'Upload File Path:'.$path]);
            return \Redirect::to('admin/image');
        }
        // 登録処理
        if (Image::insert($request, $attrs)) {
            flash(config('messages.common.success'))->success();
        } else {
            flash(config('messages.error.insert'))->error();
            \Log::warning(['Insert Fail', $request->all(), $attrs]);
            return \Redirect::to('admin/image');
        }
        return \Redirect::to('admin/image');
    }

    // TODO:画像編集 表示
    // TODO:画像編集 更新
    // TODO:画像削除
}
