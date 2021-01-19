<?php

namespace App\Repositories;

use App\Models\Member;
use App\Models\MembersMemberTypes;
use App\Models\MemberTypes;

/**
 * 会員のDBに関する処理を記述するクラス
 */
class MemberRepository
{

    /**
     * 会員情報の取得
     *
     * @param string $id
     * @return Member
     */
    public function getById($id)
    {
        $member = Member::find($id);
        return $member;
    }

    /**
     * 会員と会員種別の登録
     *
     * @param array $params
     * @return void
     */
    public function createMemberAndMemberTypes($params, $createdBy)
    {
        try {
            // 処理結果の変数
            $result = false;

            // パスワードを暗号化
            $params['password'] = bcrypt($params['password']);

            // 会員の登録
            $member = new Member();
            $member->name = $params['name'];
            $member->email = $params['email'];
            if (isset($params['password'])) {
                $member->password = $params['password'];
            }
            $member->created_by = $createdBy;
            $member->updated_by = $createdBy;
            $result = $member->save();
            // 会員登録に失敗した場合
            if (!$result) {
                throw new Exception("Create Member is Null.");
            }

            // 選択された会員種別の確認
            if (count($params['member_types']) === 0) {
                $params['member_types'] = [
                'members_id' => $member->id,
                'member_types_id' => config('const.member_types.general'),
            ];
            }

            // 会員種別の登録
            foreach ($params['member_types'] as $param) {
                $memberTypes = [
                'members_id' => $member->id,
                'member_types_id' => $param,
            ];
                $memberTypesList[] = $memberTypes;
            }
            $result = MembersMemberTypes::insert($memberTypesList);

            // 会員種別の登録で失敗した場合
            if (is_null($result)) {
                throw new Exception("Create Member Types is Null.");
            }

            return $result;
        } catch (\Throwable $th) {
            throw new Exception($th);
        }
    }
}
