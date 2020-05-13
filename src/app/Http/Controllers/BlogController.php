<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Admin\WebBaseController;
use App\Models\Post;

class BlogController extends WebBaseController
{

    /**
     * トップページ
     *
     * @return void
     */
    public function showIndex()
    {
        $posts = Post::getPublishingAll();
        return \View::make('front.blog.index')
            ->with('posts', $posts);
    }

    /**
     * 記事詳細
     *
     * @param String $url
     * @return View
     */
    public function showDetail($url=null)
    {
        $post = Post::getByUrl($url);
        $prevLink = Post::getPageLinkUrl($post->id, true);
        $nextLink = Post::getPageLinkUrl($post->id, false);
        return \View::make('front.blog.detail')
            ->with('post', $post)
            ->with('prevLink', $prevLink)
            ->with('nextLink', $nextLink);
    }

    /**
     * カテゴリー絞り込み
     *
     * @param string $categoryName
     * @return void
     */
    public function showCategory($categoryName=null)
    {
        if (is_null($categoryName)) {
            return \Redirect::to('/');
        }
        $posts = Post::getPostCategoryAll($categoryName);
        return \View::make('front.blog.index')
            ->with('posts', $posts);
    }
}
