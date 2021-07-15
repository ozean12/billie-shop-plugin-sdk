<?php


namespace Billie\Sdk\Tests\Acceptance\Mock\Model;


use Billie\Sdk\Exception\Validation\InvalidFieldValueException;
use Billie\Sdk\Model\Request\AbstractRequestModel;
use stdClass;

class ValidationTestModel extends AbstractRequestModel
{

    /**
     * @var string
     */
    public $requiredField;

    /**
     * @var stdClass
     */
    public $expectedClassField;

    /**
     * @var null
     */
    public $nullableField;

    /**
     * @var string
     */
    public $validateThruSimpleCallbackField;

    /**
     * @var stdClass
     */
    public $validateThrowCallbackReturnValueField;

    /**
     * @var string
     */
    public $validateUrlField;

    /**
     * @inheritDoc
     */
    public function getFieldValidations()
    {
        return [
            'requiredField' => 'string',
            'expectedClassField' => stdClass::class,
            'nullableField' => '?string',
            'validateThruSimpleCallbackField' => static function (self $object, $value) {
                if ($value === 'invalid-value') {
                    throw new InvalidFieldValueException('expected-error');
                }
            },
            'validateThrowCallbackReturnValueField' => static function (self $object, $value) {
                return stdClass::class;
            },
            'validateUrlField' => '?url'
        ];
    }
}