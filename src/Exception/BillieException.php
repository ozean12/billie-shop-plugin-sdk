<?php

declare(strict_types=1);

namespace Billie\Sdk\Exception;

use Exception;

class BillieException extends Exception
{
    /**
     * @var string
     */
    protected $billieCode;

    /**
     * @param string     $message
     * @param string     $code
     * @param \Exception $previous
     */
    public function __construct($message = '', $code = '000', $previous = null)
    {
        parent::__construct($message, 0, $previous);
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
