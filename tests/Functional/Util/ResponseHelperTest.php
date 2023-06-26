<?php
/*
 * Copyright (c) Billie GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Billie\Sdk\Tests\Functional\Util;

use BadMethodCallException;
use Billie\Sdk\Exception\InvalidResponseException;
use Billie\Sdk\Tests\Functional\Mock\Model\ResponseHelperModelMock;
use Billie\Sdk\Util\ResponseHelper;
use DateTime;
use PHPUnit\Framework\TestCase;

class ResponseHelperTest extends TestCase
{
    public function testString(): void
    {
        $testData = [
            'valid-string' => 'value',
            'valid-int' => 123456,
        ];

        // test if value got returned correctly or is null if it does not exist
        $this->assertEquals('value', ResponseHelper::getString($testData, 'valid-string'));
        $this->assertEquals('value', ResponseHelper::getStringNN($testData, 'valid-string'));
        $this->assertNull(ResponseHelper::getString($testData, 'invalid-key'));

        // test if number got converted to string
        $this->assertEquals('123456', ResponseHelper::getString($testData, 'valid-int'));
        $this->assertIsString(ResponseHelper::getString($testData, 'valid-int'));
        $this->assertEquals('123456', ResponseHelper::getStringNN($testData, 'valid-int'));
        $this->assertIsString(ResponseHelper::getStringNN($testData, 'valid-int'));

        // test if value got returned correctly or is null if it does not exist
        $this->expectException(InvalidResponseException::class);
        $this->assertNull(ResponseHelper::getStringNN($testData, 'invalid-key'));
    }

    public function testInt(): void
    {
        $testData = [
            'valid-string' => 'value',
            'int' => 123456,
            'numeric-string' => '654321',
        ];

        // test if value got returned correctly or is null if it does not exist
        $this->assertEquals(123456, ResponseHelper::getInt($testData, 'int'));
        $this->assertEquals(123456, ResponseHelper::getIntNN($testData, 'int'));
        $this->assertNull(ResponseHelper::getInt($testData, 'invalid-key'));

        // test if string got NOT cast to a number (0)
        $this->assertNull(ResponseHelper::getInt($testData, 'valid-string'));

        // test if string got converted to int
        $this->assertEquals(654321, ResponseHelper::getInt($testData, 'numeric-string'));
        $this->assertIsInt(ResponseHelper::getInt($testData, 'numeric-string'));
        $this->assertEquals(654321, ResponseHelper::getIntNN($testData, 'numeric-string'));
        $this->assertIsInt(ResponseHelper::getIntNN($testData, 'numeric-string'));

        // test if value got returned correctly or is null if it does not exist
        $this->expectException(InvalidResponseException::class);
        $this->assertNull(ResponseHelper::getIntNN($testData, 'invalid-key'));
    }

    public function testIntGotNotCastedFromInvalidString(): void
    {
        $testData = [
            'valid-string' => 'value',
        ];
        $this->expectException(InvalidResponseException::class);
        $this->assertNull(ResponseHelper::getIntNN($testData, 'valid-string'));
    }

    public function testFloat(): void
    {
        $testData = [
            'valid-string' => 'value',
            'float' => 123456.78,
            'int' => 333444,
            'numeric-string' => '786543.21',
        ];

        // test if value got returned correctly or is null if it does not exist
        $this->assertEquals(123456.78, ResponseHelper::getFloat($testData, 'float'));
        $this->assertEquals(123456.78, ResponseHelper::getFloatNN($testData, 'float'));
        $this->assertNull(ResponseHelper::getFloat($testData, 'invalid-key'));

        // test if string got NOT cast to a number (0)
        $this->assertNull(ResponseHelper::getFloat($testData, 'valid-string'));

        // test if string got converted to float
        $this->assertEquals(786543.21, ResponseHelper::getFloat($testData, 'numeric-string'));
        $this->assertIsFloat(ResponseHelper::getFloat($testData, 'numeric-string'));
        $this->assertEquals(786543.21, ResponseHelper::getFloatNN($testData, 'numeric-string'));
        $this->assertIsFloat(ResponseHelper::getFloatNN($testData, 'numeric-string'));

        // test if value got returned correctly or is null if it does not exist
        $this->expectException(InvalidResponseException::class);
        $this->assertNull(ResponseHelper::getIntNN($testData, 'invalid-key'));
    }

    public function testFloatGotNotCastedFromInvalidString(): void
    {
        $testData = [
            'valid-string' => 'value',
        ];
        $this->expectException(InvalidResponseException::class);
        $this->assertNull(ResponseHelper::getFloatNN($testData, 'valid-string'));
    }

    public function testValue(): void
    {
        $testData = [
            'string' => 'value',
            'float' => 123456.78,
            'int' => 333444,
            'array' => [
                'key' => 'value',
            ],
        ];

        // test if types got not modified
        $this->assertIsString(ResponseHelper::getValue($testData, 'string'));
        $this->assertIsFloat(ResponseHelper::getValue($testData, 'float'));
        $this->assertIsInt(ResponseHelper::getValue($testData, 'int'));
        $this->assertIsArray(ResponseHelper::getValue($testData, 'array'));
    }

    public function testDateTime(): void
    {
        $testData = [
            'int' => 1686754847,
            'numeric-string' => 1686754847,
            'rfc-format' => '2023-01-02 11:30:45',
            'invalid-format' => 'something-invalid',
        ];

        // Test timestamp
        $this->assertInstanceOf(DateTime::class, ResponseHelper::getDateTime($testData, 'int', 'U'));
        $this->assertInstanceOf(DateTime::class, ResponseHelper::getDateTimeNN($testData, 'int', 'U'));
        $this->assertInstanceOf(DateTime::class, ResponseHelper::getDateTime($testData, 'numeric-string', 'U'));
        $this->assertInstanceOf(DateTime::class, ResponseHelper::getDateTimeNN($testData, 'numeric-string', 'U'));

        // Test default format
        $this->assertInstanceOf(DateTime::class, ResponseHelper::getDateTime($testData, 'rfc-format'));
        $this->assertInstanceOf(DateTime::class, ResponseHelper::getDateTimeNN($testData, 'rfc-format'));

        // test if returned null when value does not exist or can not format properly
        $this->assertNull(ResponseHelper::getDateTime($testData, 'invalid-key'));
        $this->assertNull(ResponseHelper::getDateTime($testData, 'invalid-format'));

        // test if exception got thrown if it does not exist
        $this->expectException(InvalidResponseException::class);
        $this->assertNull(ResponseHelper::getDateTimeNN($testData, 'invalid-key'));
    }

    public function testDate(): void
    {
        $testData = [
            'int' => 1686754847,
            'numeric-string' => 1686754847,
            'rfc-format' => '2023-01-02',
            'invalid-format' => 'something-invalid',
        ];

        // Test timestamp
        $this->assertInstanceOf(DateTime::class, ResponseHelper::getDate($testData, 'int', 'U'));
        $this->assertInstanceOf(DateTime::class, ResponseHelper::getDateNN($testData, 'int', 'U'));
        $this->assertInstanceOf(DateTime::class, ResponseHelper::getDate($testData, 'numeric-string', 'U'));
        $this->assertInstanceOf(DateTime::class, ResponseHelper::getDateNN($testData, 'numeric-string', 'U'));

        // Test default format
        $this->assertInstanceOf(DateTime::class, ResponseHelper::getDate($testData, 'rfc-format'));
        $this->assertInstanceOf(DateTime::class, ResponseHelper::getDateNN($testData, 'rfc-format'));

        // test if returned null when value does not exist or can not format properly
        $this->assertNull(ResponseHelper::getDate($testData, 'invalid-key'));
        $this->assertNull(ResponseHelper::getDate($testData, 'invalid-format'));

        // test if exception got thrown if it does not exist
        $this->expectException(InvalidResponseException::class);
        $this->assertNull(ResponseHelper::getDateNN($testData, 'invalid-key'));
    }

    public function testArray(): void
    {
        $testData = [
            'array' => ['a', 'b', 'c'],
            'string' => 'something-invalid',
        ];

        $this->assertIsArray(ResponseHelper::getArray($testData, 'array'));
        $this->assertCount(3, ResponseHelper::getArray($testData, 'array'));

        $this->assertNull(ResponseHelper::getArray($testData, 'invalid-key'));
        $this->assertNull(ResponseHelper::getArray($testData, 'something-invalid'));
    }

    public function testGetObject(): void
    {
        $testData = [
            'object' => [
                'key1' => 'value1',
                'key2' => 'value2',
                'sub' => [
                    'key1' => 'value1_1',
                    'key2' => 'value2_2',
                ],
            ],
            'string' => 'something-invalid',
        ];

        $result = ResponseHelper::getObject($testData, 'object', ResponseHelperModelMock::class);
        $this->assertInstanceOf(ResponseHelperModelMock::class, $result);
        $this->assertEquals('value1', $result->getObjectKey1());
        $this->assertEquals('value2', $result->getObjectKey2());
        $this->assertInstanceOf(ResponseHelperModelMock::class, $result->getSubObject());
        $this->assertEquals('value1_1', $result->getSubObject()->getObjectKey1());
        $this->assertEquals('value2_2', $result->getSubObject()->getObjectKey2());
        $this->assertNull($result->getSubObject()->getSubObject());

        $this->assertNull(ResponseHelper::getObject($testData, 'string', ResponseHelperModelMock::class));

        // test if exception got thrown if it does not exist
        $this->expectException(InvalidResponseException::class);
        $this->assertNull(ResponseHelper::getObjectNN($testData, 'invalid-key', ResponseHelperModelMock::class));
    }

    public function testInvalidMethod(): void
    {
        $this->expectException(BadMethodCallException::class);
        /**
         * @noinspection PhpUndefinedMethodInspection
         * @phpstan-ignore-next-line
         */
        ResponseHelper::getSomething();
    }
}
