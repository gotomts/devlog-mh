<?php

namespace App\Services\Helper;

class PublicImageHelper
{
    /**
     * ストレージのパス
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
            $result = config('messages.common.noitem');
        }
        return $result;
    }
}
