<?php

declare(strict_types=1);

namespace Billie\Sdk\Util;

class AddressHelper
{
    /**
     * @var string
     */
    public const STREETNUMBER_REGEX = '/^([a-zäöüß\s\d.,-]+?)\s*([\d]+(?:\s?[a-z])?(?:\s?[-|+\/]{1}\s?\d*)?\s*[a-z]?)$/iu';

    /**
     * @return string|null
     */
    public static function getStreetName(string $addressWithNumber)
    {
        $matches = self::regexMatchAddress($addressWithNumber);

        return $matches[1] ?? null;
    }

    /**
     * @return string|null
     */
    public static function getHouseNumber(string $addressWithNumber)
    {
        $matches = self::regexMatchAddress($addressWithNumber);

        return $matches[2] ?? null;
    }

    private static function regexMatchAddress(string $addressWithNumber): array
    {
        preg_match(self::STREETNUMBER_REGEX, $addressWithNumber, $matches);

        return $matches;
    }
}
