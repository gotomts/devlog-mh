<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Admin\WebBaseController;

class MemberController extends WebBaseController
{
    /**
     * 会員情報TOP
     */
    public function showIndex()
    {
        return view('front.member.index');
    }
}
