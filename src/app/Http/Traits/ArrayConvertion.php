<?php


namespace App\Http\Traits;


trait ArrayConvertion
{
    /**
     * Enum型で取得した値をArrayに変換する
     *
     * @param $enums
     * @return array
     */
    private function enumToArray($enums) {
        $array = array();
        foreach ($enums as $enum) {
            $key   = array_keys($enum->getValue());
            $value = array_values($enum->getValue());
            array_push($array, array("key" => $key[0], "value" => $value[0]));
        }
        return $array;
    }
}
