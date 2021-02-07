<?php

namespace Billie\Sdk\Exception;

class BillieException extends \Exception
{
    /**
     * @var string
     */
    protected $billieCode;

    public function __construct($message = "", $code = '000', $previous = null)
    {
        parent::__construct($message, null, $previous);
        $this->billieCode = $code;
    }

    /**
     * @return string
     */
    public function getBillieCode()
    {
        return $this->billieCode;
    }
}