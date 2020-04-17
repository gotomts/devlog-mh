<?php

namespace App\Services;

use Carbon\Carbon;

/**
 * 共通処理サービス
 *
 * @author M.Goto
 */
class CommonService
{
    public function getNow()
    {
        return new Carbon();
    }
}
