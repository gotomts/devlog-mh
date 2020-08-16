<?php

namespace App\Services\Helper;

/**
 * ファイルアップロード
 *
 * @author M.Goto
 */
class FileUploadServiceHelper
{
    /**
     * 公開一時ファイルパス
     */
    public static function getPublicTmpPath($file)
    {
        return \Storage::disk('public')->putFile(config('storage.images_path.tmp'), $file);
    }
}
