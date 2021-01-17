<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\WebBaseController;
use App\Models\Member;
use App\Models\MemberTypes;
use App\Http\Requests\Admin\Member\MemberCreateRequest;

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
        return view('admin.member.list')
                ->with('members', $members);
    }

    /**
     * 会員マスタ 新規登録
     *
     * @return View
     */
    public function showCreate()
    {
        // 会員種別の一覧を取得
        $memberTypes = MemberTypes::getAll();

        // バリデーションエラーでリダイレクトしたときのエラーメッセージ表示
        \RequestErrorServiceHelper::validateInsertError();

        return view('admin.member.create')
            ->with('memberTypes', $memberTypes);
    }

    /**
     * 会員マスタ 登録処理
     *
     * @param MemberCreateRequest $request
     * @return void
     */
    public function exeCreate(MemberCreateRequest $request)
    {
        $params = $request->all();
        \DB::beginTransaction();
        try {
            // TODO:処理未実装
            //     $result = User::insert($params);
            //     if (isset($result)) {
            //         flash(config('messages.common.success'))->success();
            //     } else {
            //         throw new Exception(config('messages.exception.insert'));
            //     }
        } catch (\Throwable $th) {
            // TODO:処理未実装
            //     \DB::rollback();
            //     \Log::error($th);
            //     flash(config('messages.exception.insert'))->error();
            //     return redirect(self::LIST);
        }
        \DB::commit();
        return redirect(self::LIST);
    }
}
