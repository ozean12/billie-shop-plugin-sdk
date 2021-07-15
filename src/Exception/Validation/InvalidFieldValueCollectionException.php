<?php

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
     *
     * @return void
     */
    public function addError($field, InvalidFieldValueException $fieldException)
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
