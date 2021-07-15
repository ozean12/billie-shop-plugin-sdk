<?php

namespace Billie\Sdk\Util;

class AddressHelper
{
    const STREETNUMBER_REGEX = '/^([a-zäöüß\s\d.,-]+?)\s*([\d]+(?:\s?[a-z])?(?:\s?[-|+\/]{1}\s?\d*)?\s*[a-z]?)$/iu';

    /**
     * @param string $addressWithNumber
     *
     * @return string|null
     */
    public static function getStreetName($addressWithNumber)
    {
        $matches = self::regexMatchAddress($addressWithNumber);

        return isset($matches[1]) ? $matches[1] : null;
    }

    /**
     * @param string $addressWithNumber
     *
     * @return string|null
     */
    public static function getHouseNumber($addressWithNumber)
    {
        $matches = self::regexMatchAddress($addressWithNumber);

        return isset($matches[2]) ? $matches[2] : null;
    }

    /**
     * @param string $addressWithNumber
     *
     * @return string|null
     */
    private static function regexMatchAddress($addressWithNumber)
    {
        preg_match(self::STREETNUMBER_REGEX, $addressWithNumber, $matches);

        return $matches;
    }
}
