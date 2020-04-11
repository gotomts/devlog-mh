<?php

namespace App\Services\Helper;

class MsgHelper
{
    // メッセージ配列
    protected $_message = null;

    /**
     * メッセージの取得
     *
     * 挿入文字列が指定されており、
     * かつメッセージIDで指定されたメッセージが配列で定義されていれば、
     * メッセージ間に $insetStr を挿入したメッセージを返却する
     *
     * @param string $code メッセージID
     * @param string $params 挿入文字列
     * @return string メッセージ
     */
    public function get($code='', $params=array())
    {
        // メッセージファイル取得
        $msgFile = base_path() . '/ini/message.ini';

        // メッセージが読み込まれてなければ取得
        if (is_null($this->_message)) {
            $msgFile = parse_ini_file($msgFile);
        }

        // メッセージ文言取得
        if (array_key_exists($code, $msgFile)) {
            $msg = $msgFile[$code];
            $result = 0 < count($params) ? $msg : vsprintf($msg, $params);
        } else {
            $result = \MsgHelper::get('MSG_NOMSG');
        }

        return $result;
    }
}
