<?php

namespace App\Services;

/**
 * ファイルアップロード
 *
 * @author M.Goto
 */
class FileUploadService
{
    /**
     * 公開一時ファイルパス
     */
    public static function getPublicTmpPath($file)
    {
        return \Storage::disk('public')->putFile(config('storage.images_path.tmp'), $file);
    }
}
