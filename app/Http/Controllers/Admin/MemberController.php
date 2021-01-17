<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Member;
use Illuminate\Http\Request;

/**
 * 管理画面 会員マスタ
 */
class MemberController extends WebBaseController
{
    /** 一覧 */
    private const LIST = 'admin/member';

    /**
     * 会員マスタ 一覧
     *
     * @return View
     */
    public function showList()
    {
        $members = Member::getAll();
        return \View::make('admin.member.list')
                ->with('members', $members);
    }
}
