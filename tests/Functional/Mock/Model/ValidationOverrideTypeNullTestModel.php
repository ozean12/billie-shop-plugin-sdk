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

/**
 * @method self setNullableField(mixed $value)
 * @method mixed getNullableField()
 *
 * @method self setNotNullableField(mixed $value)
 * @method mixed getNotNullableField()
 */
class ValidationOverrideTypeNullTestModel extends AbstractRequestModel
{
    protected string $notNullableField;

    protected ?string $nullableField = null;

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
