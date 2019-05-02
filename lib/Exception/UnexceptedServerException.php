<?php

namespace Billie\Exception;

/**
 * Class UnexceptedServerException
 *
 * @package Billie\Exception
 * @author Marcel Barten <github@m-barten.de>
 */
class UnexceptedServerException extends BillieException
{
    protected $message = 'There was an unexpected server error.';

    /**
     * @return string
     */
    public function getBillieCode()
    {
        return 'SERVER_ERROR';
    }

    /**
     * @return string
     */
    public function getBillieMessage()
    {
        return $this->message;
    }
}