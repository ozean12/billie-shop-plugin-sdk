<?php


namespace Billie\Sdk\Exception\Validation;


use Billie\Sdk\Exception\BillieException;

class InvalidFieldValueException extends BillieException
{

    public function __construct($fieldName, $object, $expectedType)
    {
        parent::__construct(sprintf(
            'The field %s of the model %s has an invalid value. Expected type: %s',
            $fieldName,
            get_class($object),
            $expectedType
        ));
    }
}