<?php
/*
 * Copyright (c) Billie GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1); // strict type disabled because we are testing different wrong types of parameters

namespace Billie\Sdk\Tests\Functional\Util;

use Billie\Sdk\Exception\Validation\InvalidFieldException;
use Billie\Sdk\Exception\Validation\InvalidFieldValueException;
use Billie\Sdk\Tests\Functional\Mock\Model\ValidationTestModel;
use Billie\Sdk\Util\Validation;
use PHPUnit\Framework\TestCase;
use stdClass;

class ValidationTest extends TestCase
{
    public function testRequiredFields(): void
    {
        Validation::validatePropertyValue(
            new ValidationTestModel(),
            'requiredStringField',
            'value-should-be-set'
        );

        self::expectException(InvalidFieldValueException::class);

        Validation::validatePropertyValue(
            new ValidationTestModel(),
            'requiredStringField',
            null
        );
    }

    public function testNullable(): void
    {
        Validation::validatePropertyValue(
            new ValidationTestModel(),
            'notRequiredStringField',
            'value-should-be-set'
        );

        Validation::validatePropertyValue(
            new ValidationTestModel(),
            'notRequiredStringField',
            null
        );

        self::assertTrue(true); // just an empty test
    }

    public function testCallbackRequired(): void
    {
        $callback = static function (...$arguments): string {
            self::assertCount(2, $arguments);
            self::assertInstanceOf(ValidationTestModel::class, $arguments[0]);
            self::assertNull($arguments[1]);

            return 'string';
        };

        self::expectException(InvalidFieldValueException::class);
        Validation::validatePropertyValue(
            new ValidationTestModel(),
            'callbackValidationField',
            null,
            $callback
        );
    }

    public function testCallbackNotRequired(): void
    {
        $callback = static function (...$arguments): string {
            self::assertCount(2, $arguments);
            self::assertInstanceOf(ValidationTestModel::class, $arguments[0]);
            self::assertNull($arguments[1]);

            return Validation::TYPE_STRING_OPTIONAL;
        };

        Validation::validatePropertyValue(
            new ValidationTestModel(),
            'callbackValidationField',
            null,
            $callback
        );

        self::assertTrue(true);
    }

    public function testInvalidTypes(): void
    {
        Validation::validatePropertyValue(
            new ValidationTestModel(),
            'expectedClassField',
            new stdClass()
        );

        self::expectException(InvalidFieldValueException::class);
        Validation::validatePropertyValue(
            new ValidationTestModel(),
            'expectedClassField',
            new ValidationTestModel()
        );
    }

    public function testInvalidTypesNullable(): void
    {
        Validation::validatePropertyValue(
            new ValidationTestModel(),
            'expectedNullableClassField',
            new stdClass()
        );

        self::expectException(InvalidFieldValueException::class);
        Validation::validatePropertyValue(
            new ValidationTestModel(),
            'expectedNullableClassField',
            new ValidationTestModel()
        );
    }

    public function testArrayOfTypesValid(): void
    {
        Validation::validatePropertyValue(
            new ValidationTestModel(),
            'validateArray',
            [
                'value1',
                'value2',
            ],
            'string[]'
        );

        Validation::validatePropertyValue(
            new ValidationTestModel(),
            'validateArray',
            [
                new stdClass(),
                new stdClass(),
            ],
            stdClass::class . '[]'
        );

        self::assertTrue(true);
    }

    public function testArrayOfTypesInvalid(): void
    {
        self::expectException(InvalidFieldValueException::class);
        Validation::validatePropertyValue(
            new ValidationTestModel(),
            'validateArray',
            [
                new stdClass(),
                'value2',
            ],
            'string[]'
        );
    }

    public function testArrayNullableWithTypes(): void
    {
        Validation::validatePropertyValue(
            new ValidationTestModel(),
            'validateNullableArray',
            [],
            '?' . stdClass::class . '[]'
        );

        Validation::validatePropertyValue(
            new ValidationTestModel(),
            'validateNullableArray',
            null,
            '?' . stdClass::class . '[]'
        );

        Validation::validatePropertyValue(
            new ValidationTestModel(),
            'validateNullableArray',
            [
                new stdClass(),
                new stdClass(),
            ],
            '?' . stdClass::class . '[]'
        );

        self::assertTrue(true);
    }

    public function testArrayNullableWithInvalidTypes(): void
    {
        self::expectException(InvalidFieldValueException::class);

        Validation::validatePropertyValue(
            new ValidationTestModel(),
            'validateNullableArray',
            [
                new stdClass(),
                'test',
            ],
            '?' . stdClass::class . '[]'
        );
    }

    public function testArrayOfTypesInvalidInstance(): void
    {
        self::expectException(InvalidFieldValueException::class);
        Validation::validatePropertyValue(
            new ValidationTestModel(),
            'validateArray',
            [
                'value1',
                'value2',
            ],
            stdClass::class . '[]'
        );
    }

    public function testUrlValid(): void
    {
        Validation::validatePropertyValue(
            new ValidationTestModel(),
            'requiredStringField',
            'https://www.example.com/path/to/file/or/dir',
            Validation::TYPE_URL_REQUIRED
        );

        Validation::validatePropertyValue(
            new ValidationTestModel(),
            'notRequiredStringField',
            'https://www.example.com/path/to/file/or/dir',
            Validation::TYPE_URL_OPTIONAL
        );
        self::assertTrue(true);
    }

    public function testUrlInvalid(): void
    {
        self::expectException(InvalidFieldValueException::class);

        Validation::validatePropertyValue(
            new ValidationTestModel(),
            'requiredStringField',
            'invalid-value',
            Validation::TYPE_URL_REQUIRED
        );
    }

    public function testUrlNull(): void
    {
        self::expectException(InvalidFieldValueException::class);

        Validation::validatePropertyValue(
            new ValidationTestModel(),
            'notRequiredStringField',
            null,
            Validation::TYPE_URL_REQUIRED
        );
    }

    public function testInvalidProperty(): void
    {
        self::expectException(InvalidFieldException::class);

        Validation::validatePropertyValue(
            new ValidationTestModel(),
            'not-existing-field',
            null
        );
    }
}
