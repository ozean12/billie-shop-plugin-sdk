<?php


namespace Billie\Sdk\Util;


class ArrayHelper
{

    /**
     * @param array $array
     * @param string $find
     * @param string $replace
     * @return array
     */
    public static function replaceKeyString($array, $find, $replace)
    {
        $newArray = [];
        foreach ($array as $key => $value) {
            $newArray[str_replace($find, $replace, $key)] = $value;
        }
        return $newArray;
    }

    /**
     * @param array $array
     * @param string $prefix
     * @return array
     */
    public static function prefixArrayKeysWithString($array, $prefix)
    {
        $newArray = [];
        foreach ($array as $key => $value) {
            $newArray[$prefix . $key] = $value;
        }
        return $newArray;
    }

}