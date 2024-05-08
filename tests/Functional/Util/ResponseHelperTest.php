<?php
/*
 * Copyright (c) Billie GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Billie\Sdk\Tests\Functional\Util;

use Billie\Sdk\Exception\InvalidResponseException;
use Billie\Sdk\Model\AbstractModel;
use Billie\Sdk\Tests\Functional\Mock\Model\SimpleTestModel;
use Billie\Sdk\Util\ResponseHelper;
use DateTime;
use Exception;
use PHPUnit\Framework\TestCase;

class ResponseHelperTest extends TestCase
{
    /**
     * @dataProvider dataProviderGetString
     * @phpstan-ignore-next-line
     */
    public function testGetStringDP(...$arguments): void
    {
        $this->dynamicTest('getString', [], ...$arguments);
    }

    public static function dataProviderGetString(): array
    {
        return [
            // should pass - value should be fetched
            ['valid-value', 'valid-value'],
            // should pass - value should be fetched
            ['', ''],
            // should pass - value should be fetched
            // should pass - an int is a valid value - should be converted
            [123456, '123456'],
            // should pass - an int is a valid value - should be converted
            [123456e5, '12345600000'],
            // should pass - a float is a valid value - should be converted
            [123456.789, '123456.789'],
        ];
    }

    /**
     * @dataProvider dataProviderGetInt
     * @phpstan-ignore-next-line
     */
    public function testGetIntDP(...$arguments): void
    {
        $this->dynamicTest('getInt', [], ...$arguments);
    }

    public static function dataProviderGetInt(): array
    {
        return [
            // should pass - valid value
            [123456, 123456],
            // should pass - valid value
            [123456e5, 12345600000],
            // should pass - we will ignore wrong types
            [123456.789, 123456],
            // should FAIL - invalid value
            ['invalid-value', null, true],
        ];
    }

    /**
     * @dataProvider dataProviderGetFloat
     * @phpstan-ignore-next-line
     */
    public function testGetFloatDP(...$arguments): void
    {
        $this->dynamicTest('getFloat', [], ...$arguments);
    }

    public static function dataProviderGetFloat(): array
    {
        return [
            // should pass - valid value
            [123456, 123456.00],
            // should pass - valid value
            [123456e5, 12345600000.00],
            // should FAIL - invalid value
            ['invalid-value', null, true],
        ];
    }

    /**
     * @dataProvider dataProviderGetBool
     * @phpstan-ignore-next-line
     */
    public function testGetBoolDP(...$arguments): void
    {
        $this->dynamicTest('getBoolean', [], ...$arguments);
    }

    public static function dataProviderGetBool(): array
    {
        return [
            // should pass - valid value
            [true, true],
            // should pass - valid value
            [false, false],
            // should pass - valid value
            [1, true],
            // should pass - valid value
            [0, false],
            // should pass - invalid value got converted to false
            ['invalid-value', false],
            // should pass - invalid value got converted to false
            [20, false],
            // should pass - invalid value got converted to false
            [-20, false],
        ];
    }

    /**
     * @dataProvider dataProviderGetDateTime
     * @phpstan-ignore-next-line
     */
    public function testGetDateTimeDP(string $format, string $givenValue, ?DateTime $expectedValue, bool $expectException = false): void
    {
        $this->dynamicTest('getDateTime', [$format], $givenValue, $expectedValue, $expectException);
    }

    /**
     * they have the same logic - so we use the same testdata. the difference is that the default-argument for the format is different.
     * @dataProvider dataProviderGetDateTime
     */
    public function testGetDateDP(string $format, string $givenValue, ?DateTime $expectedValue, bool $expectException = false): void
    {
        $this->dynamicTest('getDate', [$format], $givenValue, $expectedValue, $expectException);
    }

    public static function dataProviderGetDateTime(): array
    {
        return [
            // should pass - valid value
            /** @phpstan-ignore-next-line */
            ['Y-m-d', '2023-05-01', DateTime::createFromFormat('Y-m-d', '2023-05-01')->setTime(0, 0, 0)],
            // should pass - valid value
            ['Y-m-d H:i:s', '2023-05-01 13:45:12', (new DateTime())->setDate(2023, 05, 01)->setTime(13, 45, 12)],
            // should FAIL - invalid value
            ['Y-m-d H:i:s', 'value', null, true],
            // should FAIL - invalid value
            ['invalid-format', '', null, true],
        ];
    }

    /**
     * @dataProvider dataProviderGetArray
     * @phpstan-ignore-next-line
     */
    public function testGetArrayDP(array $givenValue, array $expectedValue, string $expectedChildClass = null, ...$arguments): void
    {
        $this->dynamicTest('getArray', [$expectedChildClass, true], $givenValue, $expectedValue, ...$arguments);
    }

    public static function dataProviderGetArray(): array
    {
        return [
            // should pass - valid value
            [[], []],
            // should pass - valid value
            [['key' => 'value'], ['key' => 'value']],
            // should pass - valid value
            [[['field_value' => 'value']], [(new SimpleTestModel())->setFieldValue('value')], SimpleTestModel::class],
            // should pass - valid value
            [[['field_value' => 'value'], ['field_value' => 'value2']], [(new SimpleTestModel())->setFieldValue('value'), (new SimpleTestModel())->setFieldValue('value2')], SimpleTestModel::class],
        ];
    }

    public function testGetArrayList(): void
    {
        // special case, if the response is just a list of objects instead an object with keys.
        $model = new class() extends AbstractModel {
            protected array $items;

            /**
             * @return SimpleTestModel[]
             */
            public function getItems(): array
            {
                return $this->items;
            }

            protected function prepareModelData(array $data): array
            {
                return [
                    'items' => static fn (string $key): ?array => ResponseHelper::getArray($data, null, SimpleTestModel::class),
                ];
            }
        };
        $model->fromArray([
            ['field_value' => 'value1'],
            ['field_value' => 'value2'],
        ]);
        static::assertIsArray($model->getItems());
        static::assertCount(2, $model->getItems());
        static::assertContainsOnlyInstancesOf(SimpleTestModel::class, $model->getItems());
        static::assertEquals('value1', $model->getItems()[0]->getFieldValue());
        static::assertEquals('value2', $model->getItems()[1]->getFieldValue());
    }

    /**
     * @dataProvider dataProviderGetObject
     * @phpstan-ignore-next-line
     */
    public function testGetObjectDP(array $givenValue, SimpleTestModel $expectedValue, bool $allowEmptyObject = false, ...$arguments): void
    {
        $this->dynamicTest('getObject', [get_class($expectedValue), false, $allowEmptyObject], $givenValue, $expectedValue, ...$arguments);
    }

    public static function dataProviderGetObject(): array
    {
        return [
            [['field_value' => 'value'], (new SimpleTestModel())->setFieldValue('value')],
            [['field_value' => 'value', 'nullable_field_value' => 'value2'], (new SimpleTestModel())->setFieldValue('value')->setNullableFieldValue('value2')],
            [['field_value' => 'value', 'another-field' => 'something-else'], (new SimpleTestModel())->setFieldValue('value')],
            [['field_value' => 'value', 'nullable_field_value' => 'value2', 'another-field' => 'something-else'], (new SimpleTestModel())->setFieldValue('value')->setNullableFieldValue('value2')],
        ];
    }

    /**
     * @param mixed $givenValue
     * @param mixed $expectedValue
     */
    private function dynamicTest(string $method, array $additionalArgs, $givenValue, $expectedValue, bool $expectException = false): void
    {
        // we add another key to make sure, that the response helper will work with multiple keys
        $key = 'key';

        if ($method !== 'getBoolean') {
            $additionalArgs[] = false;
        }

        $data = [
            '__another-key-with-some-other-data' => '-/-',
            $key => $givenValue,
        ];

        if ($expectException) {
            static::expectException(InvalidResponseException::class);
        }

        $value = ResponseHelper::{$method}($data, $key, ...$additionalArgs);

        if ($expectException) {
            return;
        }

        if (is_array($expectedValue)) {
            foreach ($expectedValue as $k => $v) {
                $expectedValue[$k] = $v instanceof AbstractModel ? $v->toArray() : $v;
            }

            if (is_array($value)) {
                foreach ($value as $k => $v) {
                    $value[$k] = $v instanceof AbstractModel ? $v->toArray() : $v;
                }
            }
        }

        static::assertEquals($expectedValue, $value);

        if ($method === 'getBoolean') {
            // special case: we will return false, if value is NULL.
            // so an exception got never thrown.
            return;
        }

        $thrownException = null;
        try {
            $data[$key] = null;
            ResponseHelper::{$method}($data, $key, ...$additionalArgs);
            /** @phpstan-ignore-next-line */
        } catch (Exception $exception) {
            $thrownException = $exception;
        }

        /** @phpstan-ignore-next-line */
        static::assertInstanceOf(InvalidResponseException::class, $thrownException ?: null, 'InvalidResponseException should be thrown');
        /** @phpstan-ignore-next-line */
        static::assertMatchesRegularExpression('/was expected in response/', $thrownException->getMessage());

        static::expectException(InvalidResponseException::class);
        static::expectExceptionMessageMatches('/was expected in response/');
        unset($data[$key]);
        ResponseHelper::{$method}($data, $key, ...$additionalArgs);
    }
}
