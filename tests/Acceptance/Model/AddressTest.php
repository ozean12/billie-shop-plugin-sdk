<?php

declare(strict_types=1);

namespace Billie\Sdk\Tests\Acceptance\Model;

use Billie\Sdk\Exception\Validation\InvalidFieldValueException;
use Billie\Sdk\Model\Address;

class AddressTest extends AbstractModelTestCase
{
    public function testToArray(): void
    {
        $data = (new Address())
            ->setStreet('street-name')
            ->setHouseNumber('123')
            ->setAddition('additional information')
            ->setCity('city-name')
            ->setCountryCode('DE')
            ->setPostalCode('12345')
            ->toArray();

        static::assertEquals('street-name', $data['street']);
        static::assertEquals('123', $data['house_number']);
        static::assertEquals('additional information', $data['addition']);
        static::assertEquals(12345, $data['postal_code']);
        static::assertEquals('city-name', $data['city']);
        static::assertEquals('DE', $data['country']);
    }

    public function testInvalidData(): void
    {
        $this->expectException(InvalidFieldValueException::class);
        (new Address())->setCountryCode('ABC');

        $this->expectException(InvalidFieldValueException::class);
        (new Address())->setPostalCode('123456789');
    }
}
