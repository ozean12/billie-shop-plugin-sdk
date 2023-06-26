<?php
/*
 * Copyright (c) Billie GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Billie\Sdk\Tests\Functional\Util;

use Billie\Sdk\Model\Address;
use Billie\Sdk\Model\Amount;

class ValidModelGenerator
{
    public static function createValidAddress(): Address
    {
        return (new Address())
            ->setStreet('street-name')
            ->setHouseNumber('123')
            ->setCity('city-name')
            ->setCountryCode('DE')
            ->setPostalCode('12345');
    }

    public static function createAmount(): Amount
    {
        return (new Amount())
            ->setGross(119)
            ->setNet(100)
            ->setTax(19);
    }
}
