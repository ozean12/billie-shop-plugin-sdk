<?php


namespace Billie\Sdk\Util;


class ArrayHelper
{

    public static function replaceKeyString($array, $find, $replace)
    {
        $newArray = [];
        foreach ($array as $key => $value) {
            $newArray[str_replace($find, $replace, $key)] = $value;
        }
        return $newArray;
    }

}