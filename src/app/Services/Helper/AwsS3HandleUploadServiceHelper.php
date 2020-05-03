<?php

namespace App\Services\Helper;

/**
 * 共通処理サービス
 *
 * @author M.Goto
 */
class AwsS3HandleUploadServiceHelper
{
    /**
     * AWS S3へファイルをアップロード
     *
     * @return void
     */
    public static function upload($file)
    {
        $path = null;
        if (isset($file)) {
            $path = \Storage::disk('s3')->putFile(config('storage.aws_file_path.images'), $file, 'public');
        } else {
            return $path;
        }
        return $path;
    }

    /**
     * S3から返却されたパスを元に、正しくアップロードできたか確認する
     *
     * @param [type] $path
     * @return bool
     */
    public static function checkUpload($path)
    {
        $result = false;
        if (isset($path)) {
            // 一時ファイルを削除
            \Storage::disk('public')->delete(session('tmpPath'));
            $result = true;
        } else {
            // 一時ファイルを削除
            \Storage::disk('public')->delete(session('tmpPath'));
        }
        return $result;
    }
}
