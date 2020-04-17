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
        $request->session()->flash('tmpPath', session('tmpPath'));
        // $images['tmpPath'] = \PublicImageHelper::get(session('tmpPath'));
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
        $inputs = $request->all();
        \DB::beginTransaction();
        try {
            $file = \Storage::disk('public')->path(session('tmpPath'));
            $path = \Storage::disk('s3')->putFile(config('storage.aws_file_path.images'), $file, 'public');
            if (isset($path)) {
                // アップロード先URL取得
                $inputs['url'] = config('app.s3_url').$path;
                // 一時ファイルを削除
                \Storage::disk('public')->delete(session('tmpPath'));
            } else {
                // 一時ファイルを削除
                \Storage::disk('public')->delete(session('tmpPath'));
                // TODO:AWS S3への保存が失敗した場合
            }
            if (ImageLogic::insert($inputs)) {
                // TODO:insert成功時の処理を作成
            } else {
                // TODO:insert失敗時の処理を作成
            }
        } catch (\Throwable $th) {
            //throw $th;
            $path = \Storage::disk('s3')->delete($path);
            return $th;
        }
        \DB::commit();

        // TODO:登録成功時メッセージ作成

        return \Redirect::to('admin/image');
    }

    // TODO:画像編集 表示
    // TODO:画像編集 更新
    // TODO:画像削除
}
