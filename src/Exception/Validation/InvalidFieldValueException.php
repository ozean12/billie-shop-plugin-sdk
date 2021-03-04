<?php

namespace Billie\Sdk\Exception\Validation;

use Billie\Sdk\Exception\BillieException;

class InvalidFieldValueException extends BillieException
{
    public function __construct($message)
    {
        parent::__construct($message);
    }
}
