<?php

namespace Billie\Util;

class AddressHelper
{
    const STREETNUMBER_REGEX = '/^([a-zäöüß\s\d.,-]+?)\s*([\d]+(?:\s?[a-z])?(?:\s?[-|+\/]{1}\s?\d*)?\s*[a-z]?)$/iu';

    public static function getStreetName($addressWithNumber)
    {
        $matches = self::regexMatchAddress($addressWithNumber);

        return isset($matches[2]) ? $matches[2] : null;
    }

    public static function getHouseNumber($addressWithNumber)
    {
        $matches = self::regexMatchAddress($addressWithNumber);

        return isset($matches[1]) ? $matches[1] : null;
    }

    private static function regexMatchAddress($addressWithNumber)
    {
        preg_match(self::STREETNUMBER_REGEX, $addressWithNumber, $matches);

        return $matches;
    }
}
