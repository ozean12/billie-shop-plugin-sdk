<?php

declare(strict_types=1);

namespace Billie\Sdk\Exception\Validation;

use Billie\Sdk\Exception\BillieException;

class InvalidFieldValueCollectionException extends BillieException
{
    /**
     * @var array<InvalidFieldValueException>
     */
    protected $errors = [];

    /**
     * @param string $field
     */
    public function addError($field, InvalidFieldValueException $fieldException): void
    {
        $this->errors[$field] = $fieldException;

        $this->message = 'Field validation errors: ';
        foreach ($this->errors as $_field => $error) {
            $this->message .= "\n" . $_field . ': ' . $error->getMessage();
        }
    }

    /**
     * @return InvalidFieldValueException[]
     */
    public function getErrors()
    {
        return $this->errors;
    }
}
