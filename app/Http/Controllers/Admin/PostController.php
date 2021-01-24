<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\Post\PostRequest;
use App\Models\Post;
use App\Repositories\MemberTypesRepository;

class PostController extends WebBaseController
{

    /** 編集トップ */
    private const TOP = 'admin/post';

    protected $memberTypesRepository;

    public function __construct()
    {
        $this->memberTypesRepository = new MemberTypesRepository();
    }

    /**
     * 投稿管理 一覧表示
     *
     * @return void
     */
    public function showIndex()
    {
        // 記事情報の取得
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
        // 会員種別の取得
        $memberTypes = $this->memberTypesRepository->getAll();
        \RequestErrorServiceHelper::validateInsertError();
        return \View::make('admin.post.create')
            ->with('memberTypes', $memberTypes);
    }

    /**
     * 投稿管理 登録処理
     *
     * @return void
     */
    public function exeCreate(PostRequest $request)
    {
        $file = $request->file('imagefile');
        $params = $request->all();
        // 画像アップロードがあった場合
        if (isset($file)) {
            $path = \AwsS3HandleUploadServiceHelper::upload($file);
            // アップロード確認
            if (\AwsS3HandleUploadServiceHelper::checkUpload($path)) {
                // アップロード先URL取得
                $params['post_images_url'] = config('app.s3_url').$path;
                $params['post_images_name'] = $file->getClientOriginalName();
            } else {
                flash(config('messages.error.file_upload'))->error();
                \Log::error('Upload File Path:'.$path);
                return redirect('admin/post');
            }
        }
        \DB::beginTransaction();
        try {
            if (isset($file)) {
                $result = Post::insertWithPostImage($params);
            } else {
                $result = Post::insert($params);
            }
            if ($result) {
                flash(config('messages.common.success'))->success();
            } else {
                flash(config('messages.exception.insert'))->error();
                return redirect(self::TOP);
            }
        } catch (\Throwable $th) {
            \DB::rollBack();
            flash(config('messages.exception.insert'))->error();
            \Log::error($th);
            return redirect(self::TOP);
        }
        \DB::commit();
        return redirect(self::TOP);
    }

    /**
     * 投稿管理 編集画面表示処理
     *
     * @return void
     */
    public function showEdit($id=null)
    {
        // 記事の取得
        $post = Post::getById($id);
        // 会員種別の取得
        $memberTypes = $this->memberTypesRepository->getAll();
        // 記事が見つからない場合
        if (is_null($post)) {
            return back()->with('error', config('messages.common.nodata'));
        }
        \RequestErrorServiceHelper::validateUpdateError();
        return \View::make('admin.post.edit')
            ->with('post', $post)
            ->with('memberTypes', $memberTypes);
    }

    /**
     * 投稿管理 更新処理
     *
     * @return void
     */
    public function exeEdit($id=null, PostRequest $request)
    {
        // 更新処理
        \DB::beginTransaction();
        try {
            $file = $request->file('imagefile');
            $attrs = [];
            // 画像アップロードがあった場合
            if (isset($file)) {
                $path = \AwsS3HandleUploadServiceHelper::upload($file);
                // アップロード確認
                if (\AwsS3HandleUploadServiceHelper::checkUpload($path)) {
                    // アップロード先URL取得
                    $attrs['post_images_url'] = config('app.s3_url').$path;
                    $attrs['post_images_name'] = $file->getClientOriginalName();
                } else {
                    flash(config('messages.error.file_upload'))->error();
                    \Log::error('Upload File Path:'.$path);
                    return redirect('admin/post');
                }
            }
            if (isset($file)) {
                $result = Post::updateByIdWithPostImage($id, $request, $attrs);
            } else {
                $result = Post::updateById($id, $request);
            }
            if ($result) {
                flash(config('messages.common.success'))->success();
            } else {
                flash(config('messages.exception.insert'))->error();
                return redirect(self::TOP);
            }
        } catch (\Throwable $th) {
            \DB::rollback();
            flash(config('messages.exception.update'))->error();
            \Log::error($th);
            return redirect(self::TOP);
        }
        \DB::commit();
        return redirect(self::TOP);
    }
}
