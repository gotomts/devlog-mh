<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\Post\PostRequest;
use App\Models\Post;
use App\Services\AwsS3HandleUploadService;
use App\Services\RequestErrorService;

class PostController extends WebBaseController
{

    /** 編集トップ */
    private const TOP = 'admin/post';

    /**
     * 投稿管理 一覧表示
     *
     * @return void
     */
    public function showIndex()
    {
        $posts = Post::getAll();
        return \View::make('admin.post.list')
            ->with('posts', $posts);
    }

    /**
     * 投稿管理 登録画面表示処理
     *
     * @return void
     */
    public function showCreate()
    {
        RequestErrorService::validateInsertError();
        return \View::make('admin.post.create');
    }

    /**
     * 投稿管理 登録処理
     *
     * @return void
     */
    public function exeCreate(PostRequest $request)
    {
        $file = $request->file('imagefile');
        // 画像アップロードがあった場合
        if (isset($file)) {
            $path = AwsS3HandleUploadService::upload($file);
            // アップロード確認
            if (AwsS3HandleUploadService::checkUpload($path)) {
                // アップロード先URL取得
                $attrs['post_images_url'] = config('app.s3_url').$path;
                $attrs['post_images_name'] = $file->getClientOriginalName();
            } else {
                flash(config('messages.error.file_upload'))->error();
                \Log::error('Upload File Path:'.$path);
                return redirect('admin/post');
            }
        }
        $attrs = [];
        \DB::beginTransaction();
        try {
            if (isset($file)) {
                $result = Post::insert($request, $attrs);
            } else {
                $result = Post::insertWithPostImage($request, $attrs);
            }
            if ($result) {
                flash(config('messages.common.success'))->success();
            } else {
                flash(config('messages.exception.insert'))->error();
                return self::TOP;
            }
        } catch (\Throwable $th) {
            \DB::rollBack();
            flash(config('messages.exception.insert'))->error();
            \Log::error($th);
            return self::TOP;
        }
        \DB::commit();
        return \Redirect::to(self::TOP);
    }

    /**
     * 投稿管理 編集画面表示処理
     *
     * @return void
     */
    public function showEdit($id=null)
    {
        # code...
    }

    /**
     * 投稿管理 更新処理
     *
     * @return void
     */
    public function exeEdit($id=null, PostRequest $request)
    {
        return \Redirect::to(self::TOP);
    }
}
