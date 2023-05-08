<?php
/*
 * Copyright (c) Billie GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Billie\Sdk\Util;

class ArrayHelper
{
    /**
     * @return array<string, mixed>
     */
    public static function replacePrefixFromKeys(array $array, string $find, string $replace): array
    {
        $newArray = [];
        foreach ($array as $key => $value) {
            $newArray[str_replace($find, $replace, $key)] = $value;
        }

        return $newArray;
    }

    /**
     * @param string $prefix prefix to remove
     */
    public static function removePrefixFromKeys(array $array, string $prefix): array
    {
        return self::replacePrefixFromKeys($array, $prefix, '');
    }

    /**
     * @param string $prefix prefix to add
     *
     * @return array<string, mixed>
     */
    public static function addPrefixToKeys(array $array, string $prefix): array
    {
        $newArray = [];
        foreach ($array as $key => $value) {
            $newArray[$prefix . $key] = $value;
        }

        return $newArray;
    }
}
