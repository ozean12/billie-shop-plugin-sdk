<?php

namespace Billie\Sdk\Exception;

/**
 * Class NotAllowedException
 *
 * @package Billie\Exception
 * @author Marcel Barten <github@m-barten.de>
 */
class NotAllowedException extends BillieException
{
    protected $message = 'This action is not allowed.';

    /**
     * @return string
     */
    public function getBillieCode()
    {
        return 'NOT_ALLOWED';
    }

    /**
     * @return string
     */
    public function getBillieMessage()
    {
        return $this->message;
    }
}