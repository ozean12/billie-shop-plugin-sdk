<?php

namespace Billie\Tests\util;

use Billie\Exception\InvalidFullAddressException;
use Billie\Model\AddressPartial;
use Billie\Util\AddressHelper;
use PHPUnit\Framework\TestCase;

class AddressHelperTest extends TestCase
{
    public function testGetPartsFromFullAddressWithValidValues()
    {
        $tests = [
            ['value' => 'Hauptstrasse 23', 'expected' => new AddressPartial('Hauptstrasse', '23')],
            ['value' => 'Hauptstrasse 15-23', 'expected' => new AddressPartial('Hauptstrasse', '15-23')],
            ['value' => 'Hauptstrasse 15 - 23', 'expected' => new AddressPartial('Hauptstrasse', '15 - 23')],
            ['value' => 'Max Strasse 15f', 'expected' => new AddressPartial('Max Strasse', '15f')],
            ['value' => 'Max Strasse 15B', 'expected' => new AddressPartial('Max Strasse', '15B')],
            ['value' => 'Max Strasse 15 B', 'expected' => new AddressPartial('Max Strasse', '15 B')],
            ['value' => 'Strasse des 17. Juni 23', 'expected' => new AddressPartial('Strasse des 17. Juni', '23')],
            ['value' => 'Strasse des 17. Juni 23-24', 'expected' => new AddressPartial('Strasse des 17. Juni', '23-24')],
            ['value' => 'Hauptstrasse 15f-h', 'expected' => new AddressPartial('Hauptstrasse', '15f-h')],
            ['value' => 'Hauptstrasse 15f - 15h', 'expected' => new AddressPartial('Hauptstrasse', '15f - 15h')],
            ['value' => 'Hauptstrasse 15f-h', 'expected' => new AddressPartial('Hauptstrasse', '15f-h')],
            ['value' => 'Hauptstrasse 15 f - h', 'expected' => new AddressPartial('Hauptstrasse', '15 f - h')],
            ['value' => 'Hauptstrasse 15+16', 'expected' => new AddressPartial('Hauptstrasse', '15+16')],
            ['value' => 'Hauptstrasse 15/16', 'expected' => new AddressPartial('Hauptstrasse', '15/16')],
            ['value' => 'Straße 42 13A', 'expected' => new AddressPartial('Straße 42', '13A')],
            ['value' => 'Straße 42 13', 'expected' => new AddressPartial('Straße 42', '13')],
            ['value' => 'Musterstr.13', 'expected' => new AddressPartial('Musterstr.', '13')],
            ['value' => 'Musterstr. 13', 'expected' => new AddressPartial('Musterstr.', '13')],
        ];


        foreach ($tests as $test) {
            $this->assertEquals($test['expected'], AddressHelper::getPartsFromFullAddress($test['value']));
        }
    }

    public function testGetPartsFromFullAddressWithInvalidValues()
    {
        $tests = [
            ['value' => 'Musterstrasse'],
            ['value' => 'Postfach ABC'],
        ];


        foreach ($tests as $test) {
            $this->expectException(InvalidFullAddressException::class);
            AddressHelper::getPartsFromFullAddress($test['value']);
        }
    }
}
