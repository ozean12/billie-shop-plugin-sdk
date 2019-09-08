<?php

namespace Billie\Util;

use Billie\Exception\InvalidFullAddressException;
use Billie\Model\AddressPartial;

class AddressHelper
{
    /**
     * @param $fullAddress
     * @return AddressPartial
     * @throws InvalidFullAddressException
     */
    public static function getPartsFromFullAddress($fullAddress)
    {
        $parts = self::getParts($fullAddress);

        if (!isset($parts[1]) || !isset($parts[2])) {
            throw new InvalidFullAddressException('The full address cannot be resolved.');
        }

        return new AddressPartial($parts[1], $parts[2]);
    }

    private static function getParts($fullAddress)
    {
        $pattern = '/^([a-zäöüß\s\d.,-]+?)\s*([\d]+(?:\s?[a-z])?(?:\s?[-|+\/]{1}\s?\d*)?\s*[a-z]?)$/i';
        preg_match($pattern, $fullAddress, $matches);
        return $matches;
    }
}
