<?php

namespace Billie\Sdk\Util;

class ArrayHelper
{
    /**
     * @param array  $array
     * @param string $find
     * @param string $replace
     *
     * @return array
     */
    public static function replacePrefixFromKeys($array, $find, $replace)
    {
        $newArray = [];
        foreach ($array as $key => $value) {
            $newArray[str_replace($find, $replace, $key)] = $value;
        }

        return $newArray;
    }

    /**
     * @param array  $array
     * @param string $prefix prefix to remove
     *
     * @return array
     */
    public static function removePrefixFromKeys($array, $prefix)
    {
        return self::replacePrefixFromKeys($array, $prefix, '');
    }

    /**
     * @param array  $array
     * @param string $prefix prefix to add
     *
     * @return array
     */
    public static function addPrefixToKeys($array, $prefix)
    {
        $newArray = [];
        foreach ($array as $key => $value) {
            $newArray[$prefix . $key] = $value;
        }

        return $newArray;
    }
}
