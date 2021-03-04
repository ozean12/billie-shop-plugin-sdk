<?php

namespace Billie\Sdk\Exception\Validation;

use Billie\Sdk\Exception\BillieException;

class InvalidFieldValueCollectionException extends BillieException
{
    protected $errors = [];

    public function addError($field, InvalidFieldValueException $fieldException)
    {
        $this->errors[$field] = $fieldException;
        $this->message = implode(', ', array_keys($this->errors));
    }

    /**
     * @return InvalidFieldValueException[]
     */
    public function getErrors()
    {
        return $this->errors;
    }
}
