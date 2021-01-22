<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\WebBaseController;
use App\Models\Member;
use App\Models\MemberTypes;
use App\Repositories\MemberRepository;
use App\Repositories\MemberTypesRepository;
use App\Http\Requests\Admin\Member\MemberCreateRequest;
use App\Http\Requests\Admin\Member\MemberUpdateRequest;

/**
 * 管理画面 会員マスタ
 */
class MemberController extends WebBaseController
{
    /** 一覧 */
    private const LIST = 'admin/member';

    protected $memberRepository;
    protected $memberTypesRepository;

    public function __construct()
    {
        $this->memberRepository = new MemberRepository();
        $this->memberTypesRepository = new MemberTypesRepository();
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
     * @return redirect
     */
    public function exeCreate(MemberCreateRequest $request)
    {
        // フォームから送信された値を取得
        $params = $request->all();
        \DB::beginTransaction();
        try {
            \Log::info('Start Create Member.');
            // 会員登録と会員種別の登録
            $result = $this->memberRepository->createMemberAndMemberTypes($params, \Auth::guard('admin')->id());
            if (!$result) {
                throw new Exception("Create Member Unexpected.");
            }
            \DB::commit();
            \Log::info('End Create Member.');
            return redirect(self::LIST);
        } catch (\Throwable $th) {
            \DB::rollback();
            \Log::error($th);
            flash(config('messages.exception.insert'))->error();
            return redirect(self::LIST);
        }
    }

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
            $memberTypes = $this->memberTypesRepository->getAll();
            // 会員情報の取得
            \Log::info('Start Get Member By ID.');
            $member = $this->memberRepository->getById($id);

            unset($member->password);
            \Log::info('Success Get Member By ID.');

            // バリデーションエラーでリダイレクトしたときのエラーメッセージ表示
            \RequestErrorServiceHelper::validateUpdateError();
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

    /**
     * 会員マスタ 編集画面
     *
     * @param MemberUpdateRequest $request
     * @param string $id
     * @return redirect
     */
    public function exeEdit(MemberUpdateRequest $request, $id)
    {
        // フォームから送信された値を取得
        $params = $request->all();
        \DB::beginTransaction();
        try {
            \Log::info('Start Update Member.', [
                'id' => $id,
            ]);
            // 会員登録と会員種別の更新
            $result = $this->memberRepository->updateMemberAndMemberTypes($id, $params, \Auth::guard('admin')->id());
            if (!$result) {
                throw new Exception("Update Member Unexpected.");
            }
            \DB::commit();
            \Log::info('End Update Member.', [
                'id' => $id,
            ]);
            flash(config('messages.common.success'))->success();
            return redirect(self::LIST);
        } catch (\Throwable $th) {
            \DB::rollback();
            \Log::error($th);
            flash(config('messages.exception.update'))->error();
            return redirect(self::LIST);
        }
    }
}
