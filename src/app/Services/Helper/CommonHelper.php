<?php

namespace App\Services\Helper;

use Carbon\Carbon;

/**
 * 共通処理サービス
 *
 * @author M.Goto
 */
class CommonHelper
{
    public function getNow()
    {
        return new Carbon();
    }
}
