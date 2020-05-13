<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Admin\WebBaseController;
use App\Models\Post;

class BlogController extends WebBaseController
{
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
}
