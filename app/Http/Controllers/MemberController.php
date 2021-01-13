<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Admin\WebBaseController;
use App\Models\Member;

class MemberController extends WebBaseController
{
    /**
     * 会員情報TOP
     *
     * @return View
     */
    public function showIndex()
    {
        return view('front.member.index');
    }

    /**
     * 会員情報編集 画面表示
     *
     * @return View
     */
    public function showEdit()
    {
        $id = \Auth::user()->id;
        $member = Member::getById($id);
        // 会員が見つからない場合
        if (is_null($member)) {
            flash(config('messages.common.noitem'))->error();
            return back();
        }
        return view('front.member.edit')
            ->with('member', $member);
    }
}
