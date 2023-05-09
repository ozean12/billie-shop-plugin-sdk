<?php
/*
 * Copyright (c) Billie GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Billie\Sdk\Tests\Functional\Mock\Model;

use Billie\Sdk\Model\Request\AbstractRequestModel;
use stdClass;

/**
 * @method self setRequiredStringField(string $requiredField)
 * @method string getRequiredStringField()
 *
 * @method self setNotRequiredStringField(string|null $requiredField)
 * @method string|null getNotRequiredStringField()
 *
 * @method self setExpectedClassField(string $expectedClassField)
 * @method stdClass getExpectedClassField()
 *
 * @method self setExpectedNullableClassField(string|null $expectedClassField)
 * @method stdClass|null getExpectedNullableClassField()
 *
 * @method self setCallbackValidationField($value)
 * @method mixed getCallbackValidationField()
 *
 * @method self setValidateUrlField(string $validateUrlField)
 * @method string getValidateUrlField()
 *
 * @method self setValidateNullableUrlField(string $validateNullableUrlField)
 * @method string|null getValidateNullableUrlField()
 *
 * @method self setValidateArray(array $list)
 * @method array getValidateArray()
 *
 * @method self setValidateNullableArray(array|null $list)
 * @method array|null getValidateNullableArray()
 */
class ValidationTestModel extends AbstractRequestModel
{
    protected string $requiredStringField;

    protected ?string $notRequiredStringField = null;

    protected stdClass $expectedClassField;

    protected ?stdClass $expectedNullableClassField = null;

    /**
     * @var mixed
     */
    protected $callbackValidationField;

    protected string $validateUrlField;

    protected ?string $validateNullableUrlField = null;

    protected array $validateArray = [];

    protected ?array $validateNullableArray = [];

    private array $fieldValidations = [];

    /**
     * @param string|callable|null $validation
     */
    public function setFieldValidation(string $field, $validation): void
    {
        $this->fieldValidations[$field] = $validation;
    }

    protected function getFieldValidations(): array
    {
        return $this->fieldValidations;
    }
}
