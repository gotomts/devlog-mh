<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\WebBaseController;
use App\Models\Member;
use App\Models\MemberTypes;
use App\Repositories\MemberRepository;
use App\Http\Requests\Admin\Member\MemberCreateRequest;

/**
 * 管理画面 会員マスタ
 */
class MemberController extends WebBaseController
{
    /** 一覧 */
    private const LIST = 'admin/member';

    protected $memberRepository;

    public function __construct()
    {
        $this->memberRepository = new MemberRepository();
    }

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
        \Log::info('Start Create Member.');
        \DB::beginTransaction();
        try {
            $result = $this->memberRepository->createMemberAndMemberTypes($params, \Auth::guard('admin')->id());
            if (!$result) {
                throw new Exception("Create Member Unexpected.");
            }
        } catch (\Throwable $th) {
            \DB::rollback();
            \Log::error($th);
            flash(config('messages.exception.insert'))->error();
            return redirect(self::LIST);
        }
        \DB::commit();
        \Log::info('End Create Member.');
        return redirect(self::LIST);
    }
}
