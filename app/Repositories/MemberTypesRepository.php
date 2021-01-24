<?php

namespace App\Repositories;

use App\Models\MemberTypes;

/**
 * 会員種別のDBに関する処理を記述するクラス
 */
class MemberTypesRepository
{

    /**
     * 会員種別名を取得
     *
     * @return array
     */
    public function getAll()
    {
        return MemberTypes::all();
    }
}
