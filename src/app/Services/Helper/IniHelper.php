<?php

namespace App\Services\Helper;

class IniHelper
{
    // 項目値配列
    protected static $_iniArray = null;

    /**
     * 定数値の取得
     *
     * @param string $section セクション名
     * @param boolean $global グローバル項目の取得指示
     * @param string $itemcd 項目名
     * @return array($id, 名前)
     */
    public function get($section = '', $global = false, $itemcd = '')
    {
        // 読み込まれてなければ取得
        if (is_null(self::$_iniArray)) {
            // 項目定数ファイル取得
            $inifile = base_path() . '/ini/items.ini';
            // 定数情報取得
            self::$_iniArray = parse_ini_file($inifile, true);
        }

        $result = null;
        // 指定項目取得
        if (array_key_exists($itemcd, self::$_iniArray)) {
            // global指示があれば返却
            if ($global) {
                $result = self::$_iniArray['global'] + self::$_iniArray[$section];
            } else {
                $result = self::$_iniArray[$section];
            }
            // 項目コードが指示されている場合、その対象項目を返す
            if ($itemcd) {
                // キー存在確認
                if (array_key_exists($itemcd, $result)) {
                    $result = $result[$itemcd];
                } else {
                    $result = \MsgHelper::get('MSG_NOITEM');
                }
            }
        } else {
            $result = array(\MsgHelper::get('MSG_NOITEM'));
        }

        return $result;
    }
}
