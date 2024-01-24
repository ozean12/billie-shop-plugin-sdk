<?php
/*
 * Copyright (c) Billie GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Billie\Sdk\Tests\Functional\Util;

use Billie\Sdk\Util\AddressHelper;
use PHPUnit\Framework\TestCase;

class AddressHelperTest extends TestCase
{
    /**
     * @dataProvider getSimpleAddressesToTest
     */
    public function testGetStreetName(string $input, string $expectedStreet, string $expectedHouseNumber): void
    {
        static::assertEquals($expectedStreet, AddressHelper::getStreetName($input));
        static::assertEquals($expectedHouseNumber, AddressHelper::getHouseNumber($input));
    }

    public function getSimpleAddressesToTest(): array
    {
        return [
            ['This is the street 123', 'This is the street', '123'],
            ['This is the street123', 'This is the street', '123'],

            ['This is the street 123a', 'This is the street', '123a'],
            ['This is the street123a', 'This is the street', '123a'],

            ['This is the street 123 a', 'This is the street', '123 a'],
            ['This is the street123 a', 'This is the street', '123 a'],

            ['This is the street 123a-g', 'This is the street', '123a-g'],
            ['This is the street123a-g', 'This is the street', '123a-g'],

            ['This is the street 123 a-g', 'This is the street', '123 a-g'],
            ['This is the street123 a-g', 'This is the street', '123 a-g'],

            ['This is the street 1a-g', 'This is the street', '1a-g'],
            ['This is the street1a-g', 'This is the street', '1a-g'],

            ['This is the street 1 a-g', 'This is the street', '1 a-g'],
            ['This is the street1 a-g', 'This is the street', '1 a-g'],

            ['This is the street 123', 'This is the street', '123'],
            ['This-is the-street 123', 'This-is the-street', '123'],

            ['This-is-the street 123', 'This-is-the street', '123'],
            ['This-IS-the streetß 123', 'This-IS-the streetß', '123'],
            ['This-äöü-the street 123', 'This-äöü-the street', '123'],

            ['This is the street 123/2', 'This is the street', '123/2'],
            ['This is the street123/2', 'This is the street', '123/2'],

            ['This is the street 123-2', 'This is the street', '123-2'],
            ['This is the street123-2', 'This is the street', '123-2'],
        ];
    }
}
