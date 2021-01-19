<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\WebBaseController;
use App\Models\Member;
use App\Models\MemberTypes;
use App\Repositories\MemberRepository;
use App\Repositories\MemberTypesRepository;
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
        $this->MemberTypesRepository = new MemberTypesRepository();
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

    /**
     * 会員マスタ 編集画面
     *
     * @param string $id
     * @return View
     */
    public function showEdit($id)
    {
        try {
            // 会員種別の一覧を取得
            $memberTypes = $this->MemberTypesRepository->getAll();
            // 会員情報の取得
            \Log::info('Start Get Member By ID.');
            $member = $this->memberRepository->getById($id);

            unset($member->password);
            \Log::info('Success Get Member By ID.');

            // バリデーションエラーでリダイレクトしたときのエラーメッセージ表示
            \RequestErrorServiceHelper::validateInsertError();
            // 会員マスタ編集画面を表示
            return view('admin.member.edit')
                ->with('member', $member)
                ->with('memberTypes', $memberTypes);
        } catch (\Throwable $th) {
            \Log::error($th);
            flash(config('messages.exception.select'))->error();
            return redirect(self::LIST);
        }
    }
}
