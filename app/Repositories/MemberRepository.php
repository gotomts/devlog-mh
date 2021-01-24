<?php

namespace App\Repositories;

use App\Models\Member;
use App\Models\MembersMemberTypes;

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
     * @return bool
     */
    public function createMemberAndMemberTypes($params, $createdBy)
    {
        try {
            // 処理結果の変数
            $result = false;

            // Memberクラスをインスタンス化
            $member = new Member();

            // 会員種別の登録
            $member->memberTypes()->attach($params['member_types']);

            // 会員情報の登録
            $member->name = $params['name'];
            $member->email = $params['email'];
            if (isset($params['password'])) {
                // パスワードを暗号化
                $params['password'] = bcrypt($params['password']);
                $member->password = $params['password'];
            }
            $member->created_by = $createdBy;
            $member->updated_by = $createdBy;
            $result = $member->save();

            // 会員登録に失敗した場合
            if (!$result) {
                throw new Exception("Create Member Unexpected.");
            }

            return $result;
        } catch (\Throwable $th) {
            throw new Exception($th);
        }
    }

    /**
     * 会員と会員種別の更新
     *
     * @param string $id
     * @param array $params
     * @param int $updatedBy
     * @return bool|MembersMemberTypes
     */
    public function updateMemberAndMemberTypes($id, $params, $updatedBy)
    {
        try {
            // 処理結果の変数
            $result = false;

            // 会員情報を取得
            $member = $this->getById($id);

            // 会員種別の更新
            // 一旦リセットした上で改めてチェックボックスのチェック分を登録
            $member->memberTypes()->detach();
            $member->memberTypes()->attach($params['member_types']);

            // 会員情報の更新
            $member->name = $params['name'];
            $member->email = $params['email'];

            // パスワードは入力があった場合のみ更新する
            if (isset($params['password'])) {
                // パスワードを暗号化
                $params['password'] = bcrypt($params['password']);
                $member->password = $params['password'];
            }
            $member->updated_by = $updatedBy;
            $result = $member->save();

            // 会員情報の更新に失敗した場合
            if (!$result) {
                throw new Exception("Update Member Unexpected.");
            }

            return $result;
        } catch (\Throwable $th) {
            throw new Exception($th);
        }
    }
}
