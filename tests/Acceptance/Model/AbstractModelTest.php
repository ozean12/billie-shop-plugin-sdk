<?php
/*
 * Copyright (c) Billie GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Billie\Sdk\Tests\Acceptance\Model;

use BadMethodCallException;
use Billie\Sdk\Exception\Validation\InvalidFieldException;
use Billie\Sdk\Exception\Validation\InvalidFieldValueCollectionException;
use Billie\Sdk\Exception\Validation\InvalidFieldValueException;
use Billie\Sdk\Model\AbstractModel;
use Billie\Sdk\Util\Validation;
use PHPUnit\Framework\TestCase;

class AbstractModelTest extends TestCase
{
    public function testIfExceptionGotThrownOnInvalidMethod(): void
    {
        $model = new class() extends AbstractModel {
        };

        static::expectException(BadMethodCallException::class);
        /**
         * testing undefined method --> IDE and PHPStan would trigger an error
         * @noinspection PhpUndefinedMethodInspection
         * @phpstan-ignore-next-line
         */
        $model->aMethodWhichDoesNotExist();
    }

    public function testIfExceptionGotThrownOnInvalidGetProperty(): void
    {
        $model = new class() extends AbstractModel {
        };

        static::expectException(InvalidFieldException::class);
        /**
         * testing undefined property --> IDE and PHPStan would trigger an error
         * @noinspection PhpUndefinedMethodInspection
         * @phpstan-ignore-next-line
         */
        $model->getInvalidProperty();
    }

    public function testIfExceptionGotThrownOnInvalidSetProperty(): void
    {
        $model = new class() extends AbstractModel {
        };

        static::expectException(InvalidFieldException::class);
        /**
         * testing undefined property --> IDE and PHPStan would trigger an error
         * @noinspection PhpUndefinedMethodInspection
         * @phpstan-ignore-next-line
         */
        $model->setInvalidProperty();
    }

    public function testEnableDisableValidation(): void
    {
        $model = new class() extends AbstractModel {
            protected ?string $requiredProperty = null;

            protected function getFieldValidations(): array
            {
                return [
                    'requiredProperty' => Validation::TYPE_STRING_REQUIRED,
                ];
            }
        };

        $model->disableValidateOnSet();
        $model->__call('setRequiredProperty', [null]);

        static::expectException(InvalidFieldValueException::class);
        $model->enableValidateOnSet();
        $model->__call('setRequiredProperty', [null]);
    }

    public function testReadOnlyModel(): void
    {
        $model = new class([], true) extends AbstractModel {
            protected ?string $property = null;
        };

        static::expectException(BadMethodCallException::class);
        static::expectExceptionMessageMatches('/is read only\.?$/');
        $model->__call('setRequiredProperty', [null]);
    }

    public function testMultipleInvalidFields(): void
    {
        $model = new class() extends AbstractModel {
            protected ?string $requiredProperty1 = null;

            protected ?string $requiredProperty2 = null;

            protected function getFieldValidations(): array
            {
                return [
                    'requiredProperty1' => Validation::TYPE_STRING_REQUIRED,
                    'requiredProperty2' => Validation::TYPE_STRING_REQUIRED,
                ];
            }
        };

        $model->disableValidateOnSet();
        $model->__call('setRequiredProperty1', [null]);
        $model->__call('setRequiredProperty2', [null]);

        static::expectException(InvalidFieldValueCollectionException::class);
        $model->validateFields();
    }

    public function testToArrayChildObjectsGotConverted(): void
    {
        $model = new class() extends AbstractModel {
            protected AbstractModel $property1;

            protected AbstractModel $property2;
        };

        $model->disableValidateOnSet();
        $model->__call('setProperty1', [new class() extends AbstractModel {
            protected string $property1 = 'value 1-1';

            protected string $property2 = 'value 1-2';
        }]);
        $model->__call('setProperty2', [new class() extends AbstractModel {
            protected string $property1 = 'value 2-1';

            protected string $property2 = 'value 2-2';
        }]);

        $data = $model->toArray();
        $expectedData = [
            'property1' => [
                'property1' => 'value 1-1',
                'property2' => 'value 1-2',
            ],
            'property2' => [
                'property1' => 'value 2-1',
                'property2' => 'value 2-2',
            ],
        ];
        static::assertEquals($expectedData, $data);
    }
}
