<?php

namespace App\Services\Helper;

class PublicImageHelper
{
    /**
     * 定数値の取得
     *
     * @param string $filePath ファイルパス
     * @param string $storage ストレージ名
     * @return string ファイルURL
     */
    public function get($filePath, $storage = 'storage')
    {
        if (isset($filePath)) {
            $result = asset($storage . '/' . $filePath);
        } else {
            $result = \MsgHelper::get('MSG_NOITEM');
        }
        return $result;
    }
}
