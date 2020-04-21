<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\Images\ImageRequest;
use App\Http\Requests\Admin\Images\ImageUploadRequest;
use App\Models\Image;
use App\Services\AwsS3HandleUploadService;
use App\Services\FileUploadService;
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
    public function exeUpload(ImageUploadRequest $request)
    {
        $file = $request->file('imagefile');
        session()->flash('tmpPath', FileUploadService::getPublicTmpPath($file));
        return redirect()->to('admin/image/upload');
    }

    /**
     * アップロードプレビュー・編集
     *
     * @param request $request
     * @return view
     */
    public function showUpload()
    {
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
        $path = AwsS3HandleUploadService::upload($file);
        // アップロード確認
        if (AwsS3HandleUploadService::checkUpload($path)) {
            // アップロード先URL取得
            $attrs['url'] = config('app.s3_url').$path;
        } else {
            flash(config('messages.exception.file_upload'))->error();
            \Log::error('Upload File Path:'.$path);
            return redirect('admin/image');
        }
        // 登録処理
        if (Image::insert($request, $attrs)) {
            flash(config('messages.common.success'))->success();
        } else {
            flash(config('messages.exception.insert'))->error();
            return redirect('admin/image');
        }
        return redirect('admin/image');
    }

    /**
     * 画像編集 表示処理
     */
    public function showEdit($id = null)
    {
        $images = Image::getById($id);
        $errors = session('errors');
        if (isset($errors)) {
            flash(config('messages.error.update'))->error();
        }
        return \View::make('admin.image.edit')
            ->with('id', $id)
            ->with('images', $images);
    }

    /**
     * 画像編集 更新処理
     *
     * @param ImageRequest $request
     * @return void
     */
    public function exeEdit($id = null, ImageRequest $request)
    {
        // 登録処理
        if (Image::updateById($id, $request)) {
            flash(config('messages.common.success'))->success();
        } else {
            flash(config('messages.exception.update'))->error();
            return redirect('admin/image');
        }
        return redirect('admin/image');
    }
}
