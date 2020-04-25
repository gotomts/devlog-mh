<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\PostRequest;
use App\Models\Post;
use Illuminate\Http\Request;

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
        return \View::make('admin.post.create');
    }

    /**
     * 投稿管理 登録処理
     *
     * @return void
     */
    public function exeCreate(PostRequest $request)
    {
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
