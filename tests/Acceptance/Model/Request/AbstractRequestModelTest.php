<?php


namespace Billie\Sdk\Tests\Acceptance\Model\Request;


use Billie\Sdk\Exception\Validation\InvalidFieldValueCollectionException;
use Billie\Sdk\Tests\Acceptance\Mock\Model\ValidationTestModel;
use Billie\Sdk\Tests\Acceptance\Model\AbstractModelTestCase;
use stdClass;

class AbstractRequestModelTest extends AbstractModelTestCase
{

    public function testValidEntity()
    {
        $this->getValidModel()->validateFields();
    }

    public function testRequiredFields()
    {
        $model = $this->getValidModel();
        $model->requiredField = null;

        try {
            $model->validateFields();
            self::fail('exception of type `' . InvalidFieldValueCollectionException::class . '` was expected');
        } catch (InvalidFieldValueCollectionException $e) {
            self::assertArrayHasKey('requiredField', $e->getErrors());
        }
    }

    public function testNullable()
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
            self::fail('exception of type `' . InvalidFieldValueCollectionException::class . '` was expected');
        } catch (InvalidFieldValueCollectionException $e) {
            self::assertArrayHasKey('nullableField', $e->getErrors());
        }
    }

    public function testCallback()
    {
        $model = $this->getValidModel();
        $model->validateThruSimpleCallbackField = 'invalid-value';

        try {
            $model->validateFields();
            self::fail('exception of type `' . InvalidFieldValueCollectionException::class . '` was expected');
        } catch (InvalidFieldValueCollectionException $e) {
            self::assertArrayHasKey('validateThruSimpleCallbackField', $e->getErrors());
        }

        $model = new ValidationTestModel();
        $model->validateThrowCallbackReturnValueField = false; // expected type is a string
        try {
            $model->validateFields();
            self::fail('exception of type `' . InvalidFieldValueCollectionException::class . '` was expected');
        } catch (InvalidFieldValueCollectionException $e) {
            self::assertArrayHasKey('validateThrowCallbackReturnValueField', $e->getErrors());
        }
    }

    public function testTypes()
    {
        $model = $this->getValidModel();
        $model->expectedClassField = new ValidationTestModel();
        try {
            $model->validateFields();
            self::fail('exception of type `' . InvalidFieldValueCollectionException::class . '` was expected');
        } catch (InvalidFieldValueCollectionException $e) {
            self::assertArrayHasKey('expectedClassField', $e->getErrors());
        }

        $model = $this->getValidModel();
        $model->requiredField = new ValidationTestModel();
        try {
            $model->validateFields();
            self::fail('exception of type `' . InvalidFieldValueCollectionException::class . '` was expected');
        } catch (InvalidFieldValueCollectionException $e) {
            self::assertArrayHasKey('requiredField', $e->getErrors());
        }
    }

    public function testInvalidUrl()
    {
        $model = $this->getValidModel();
        $model->validateUrlField = 'invalid-value';
        try {
            $model->validateFields();
            self::fail('exception of type `' . InvalidFieldValueCollectionException::class . '` was expected');
        } catch (InvalidFieldValueCollectionException $e) {
            self::assertArrayHasKey('validateUrlField', $e->getErrors());
        }
    }

    private function getValidModel()
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