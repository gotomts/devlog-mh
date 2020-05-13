<?php

namespace App\Http\Controllers;

use App\Http\Controllers\WebBaseController;
use App\Models\Post;

class IndexController extends WebBaseController
{
    /**
     * トップページ
     *
     * @return void
     */
    public function showIndex()
    {
        $posts = Post::getPublishingAll();
        return \View::make('front.index.index')
            ->with('posts', $posts);
    }
}
