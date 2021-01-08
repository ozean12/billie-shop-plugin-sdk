<?php

namespace Billie\Sdk\Exception;

class UnexpectedServerException extends BillieException
{

    private $billieCode;

    public function __construct($message, $code)
    {
        parent::__construct($message);
        $this->billieCode = $code;
    }

    public function getBillieCode()
    {
        return $this->billieCode;
    }
}