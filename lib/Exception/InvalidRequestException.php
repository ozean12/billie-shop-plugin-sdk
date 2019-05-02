<?php

namespace Billie\Exception;

/**
 * Class InvalidRequestException
 *
 * @package Billie\Exception
 * @author Marcel Barten <github@m-barten.de>
 */
class InvalidRequestException extends BillieException
{

    protected $message;

    /**
     * InvalidRequestException constructor.
     *
     * @param string $message
     */
    public function __construct($message)
    {
        parent::__construct();
        $this->message = $message;
    }

    /**
     * @return string
     */
    public function getBillieCode()
    {
        return 'INVALID_REQUEST';
    }

    /**
     * @return string
     */
    public function getBillieMessage()
    {
        return $this->message;
    }
}