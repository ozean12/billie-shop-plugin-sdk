<?php

declare(strict_types=1);

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

    public function getFieldValidations(): array
    {
        return [
            'requiredField' => 'string',
            'expectedClassField' => stdClass::class,
            'nullableField' => '?string',
            'validateThruSimpleCallbackField' => static function (self $object, $value): void {
                if ($value === 'invalid-value') {
                    throw new InvalidFieldValueException('expected-error');
                }
            },
            'validateThrowCallbackReturnValueField' => static fn (self $object, $value): string => stdClass::class,
            'validateUrlField' => '?url',
        ];
    }
}
