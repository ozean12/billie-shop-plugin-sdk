<?php
/*
 * Copyright (c) Billie GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Billie\Sdk\Tests\Acceptance\Model;

use Billie\Sdk\Exception\Validation\InvalidFieldValueException;
use Billie\Sdk\Model\AbstractModel;
use Billie\Sdk\Model\Address;

class AddressTest extends AbstractModelTestCase
{
    public function testToArray(): void
    {
        $data = $this->getValidModel()->toArray();

        static::assertEquals('street-name', $data['street'] ?? null);
        static::assertEquals('123', $data['house_number'] ?? null);
        static::assertEquals(12345, $data['postal_code'] ?? null);
        static::assertEquals('city-name', $data['city'] ?? null);
        static::assertEquals('DE', $data['country'] ?? null);
    }

    public function testInvalidCountryCode(): void
    {
        $this->expectException(InvalidFieldValueException::class);
        (new Address())->setCountryCode('ABC');
    }

    public function testInvalidPostalCode(): void
    {
        $this->expectException(InvalidFieldValueException::class);
        $this->expectExceptionMessage('The field `postalCode` must be 5 chars long. (german postcode format)');
        (new Address())->setPostalCode('123456789');
    }

    protected function getValidModel(): AbstractModel
    {
        return (new Address())
            ->setStreet('street-name')
            ->setHouseNumber('123')
            ->setCity('city-name')
            ->setCountryCode('DE')
            ->setPostalCode('12345');
    }
}
