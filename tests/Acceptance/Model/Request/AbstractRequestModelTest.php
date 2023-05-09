<?php

declare(strict_types=1);

namespace Billie\Sdk\Tests\Acceptance\Model\Request;

use Billie\Sdk\Exception\Validation\InvalidFieldValueCollectionException;
use Billie\Sdk\Tests\Acceptance\Mock\Model\ValidationTestModel;
use Billie\Sdk\Tests\Acceptance\Model\AbstractModelTestCase;
use stdClass;

abstract class AbstractRequestModelTest extends AbstractModelTestCase
{
    public function testValidEntity(): void
    {
        $this->getValidModel()->validateFields();
    }

    public function testRequiredFields(): void
    {
        $model = $this->getValidModel();
        $model->requiredField = null;

        try {
            $model->validateFields();
            static::fail('exception of type `' . InvalidFieldValueCollectionException::class . '` was expected');
        } catch (InvalidFieldValueCollectionException $invalidFieldValueCollectionException) {
            static::assertArrayHasKey('requiredField', $invalidFieldValueCollectionException->getErrors());
        }
    }

    public function testNullable(): void
    {
        $model = $this->getValidModel();
        $model->nullableField = null;
        $model->validateFields(); // no error should occur

        $model = $this->getValidModel();

        $model->nullableField = 'string';
        $model->validateFields(); // no error should occur

        $model = $this->getValidModel();

        $model->nullableField = new stdClass(); // string is expected
        try {
            $model->validateFields();
            static::fail('exception of type `' . InvalidFieldValueCollectionException::class . '` was expected');
        } catch (InvalidFieldValueCollectionException $invalidFieldValueCollectionException) {
            static::assertArrayHasKey('nullableField', $invalidFieldValueCollectionException->getErrors());
        }
    }

    public function testCallback(): void
    {
        $model = $this->getValidModel();
        $model->validateThruSimpleCallbackField = 'invalid-value';

        try {
            $model->validateFields();
            static::fail('exception of type `' . InvalidFieldValueCollectionException::class . '` was expected');
        } catch (InvalidFieldValueCollectionException $invalidFieldValueCollectionException) {
            static::assertArrayHasKey('validateThruSimpleCallbackField', $invalidFieldValueCollectionException->getErrors());
        }

        $model = new ValidationTestModel();
        $model->validateThrowCallbackReturnValueField = false; // expected type is a string
        try {
            $model->validateFields();
            static::fail('exception of type `' . InvalidFieldValueCollectionException::class . '` was expected');
        } catch (InvalidFieldValueCollectionException $invalidFieldValueCollectionException) {
            static::assertArrayHasKey('validateThrowCallbackReturnValueField', $invalidFieldValueCollectionException->getErrors());
        }
    }

    public function testTypes(): void
    {
        $model = $this->getValidModel();
        $model->expectedClassField = new ValidationTestModel();
        try {
            $model->validateFields();
            static::fail('exception of type `' . InvalidFieldValueCollectionException::class . '` was expected');
        } catch (InvalidFieldValueCollectionException $invalidFieldValueCollectionException) {
            static::assertArrayHasKey('expectedClassField', $invalidFieldValueCollectionException->getErrors());
        }

        $model = $this->getValidModel();
        $model->requiredField = new ValidationTestModel();
        try {
            $model->validateFields();
            static::fail('exception of type `' . InvalidFieldValueCollectionException::class . '` was expected');
        } catch (InvalidFieldValueCollectionException $invalidFieldValueCollectionException) {
            static::assertArrayHasKey('requiredField', $invalidFieldValueCollectionException->getErrors());
        }
    }

    public function testInvalidUrl(): void
    {
        $model = $this->getValidModel();
        $model->validateUrlField = 'invalid-value';
        try {
            $model->validateFields();
            static::fail('exception of type `' . InvalidFieldValueCollectionException::class . '` was expected');
        } catch (InvalidFieldValueCollectionException $invalidFieldValueCollectionException) {
            static::assertArrayHasKey('validateUrlField', $invalidFieldValueCollectionException->getErrors());
        }
    }

    private function getValidModel(): ValidationTestModel
    {
        $model = new ValidationTestModel();
        $model->requiredField = 'valid-value';
        $model->expectedClassField = new stdClass();
        $model->nullableField = null;
        $model->validateThruSimpleCallbackField = 'valid-value';
        $model->validateThrowCallbackReturnValueField = new stdClass();
        $model->validateUrlField = 'https://www.domain.com/path/to/a/file.png?param1=value1&param2[]=abc&param2[]=def';

        return $model;
    }
}
