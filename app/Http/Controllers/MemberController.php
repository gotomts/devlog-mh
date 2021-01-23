<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Admin\WebBaseController;
use App\Http\Requests\Front\Member\MemberRequest;
use App\Models\Member;
use App\Models\Post;

class MemberController extends WebBaseController
{
    private const TOP = 'member/index';
    private const EDIT = 'member/edit';

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
        // バリデーションエラーが存在した場合
        \RequestErrorServiceHelper::validateUpdateError();

        return view('front.member.edit')
            ->with('member', $member);
    }

    /**
     * 会員情報編集 更新処理
     *
     * @param $request
     * @param $id
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function exeEdit(MemberRequest $request, $id)
    {
        $params = [
            'name' => $request->name,
            'email' => $request->email,
            'new_password' => $request->new_password,
        ];
        try {
            $result = Member::updateById($id, $params);
            if ($result) {
                flash(config('messages.front.member.update'))->success();
            } else {
                throw new Exception(config('messages.exception.update'));
            }
        } catch (\Throwable $th) {
            \Log::error($th);
            flash(config('messages.exception.update'))->error();
            return redirect(self::EDIT);
        }
        return redirect(self::TOP);
    }

    /**
     * 会員限定ページ一覧 表示
     *
     * @return View
     */
    public function showPost()
    {
        // 記事情報を取得
        $posts = Post::getMemberLimitationAll();
        return view('front.member.post')
            ->with('posts', $posts);
    }

    /**
     * 会員限定ページ詳細 表示
     *
     * @param string $url
     * @return View
     */
    public function showPostDetail($url=null)
    {
        $post = Post::getByUrl($url);
        $prevLink = Post::getPageLinkUrl($post->created_at, true, config('const.statuses.member_limitation'));
        $nextLink = Post::getPageLinkUrl($post->created_at, false, config('const.statuses.member_limitation'));
        return view('front.member.post_detail')
            ->with('post', $post)
            ->with('prevLink', $prevLink)
            ->with('nextLink', $nextLink);
    }

    /**
     * カテゴリー絞り込み
     *
     * @param string $categoryName
     * @return View
     */
    public function showCategory($categoryName=null)
    {
        if (is_null($categoryName)) {
            return \Redirect::to('/');
        }
        $posts = Post::getPostCategoryAll($categoryName, config('const.statuses.member_limitation'));
        return view('front.member.post')
            ->with('posts', $posts);
    }
}
