<?php

namespace App\Http\Controllers;

use App\Http\Controllers\WebBaseController;
use App\Models\Post;
use Illuminate\Http\Request;

class IndexController extends WebBaseController
{
    public function showIndex()
    {
        $posts = Post::getAll();
        return \View::make('front.index.index')
            ->with('posts', $posts);
    }
}
