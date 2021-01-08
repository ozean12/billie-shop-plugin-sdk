<?php


namespace Billie\Sdk\Exception\Validation;


use Billie\Sdk\Exception\BillieException;

class InvalidFieldException extends BillieException
{

    public function __construct($fieldName, $object)
    {
        parent::__construct(sprintf('The field %s does not exist on object %s.', $fieldName, get_class($object)));
    }
}