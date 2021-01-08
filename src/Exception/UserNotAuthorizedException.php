<?php

namespace Billie\Sdk\Exception;

/**
 * Class UserNotAuthorizedException
 *
 * @package Billie\Exception
 * @author Marcel Barten <github@m-barten.de>
 */
class UserNotAuthorizedException extends BillieException
{
    protected $message = 'The user is not authorized to perform this action.';

    /**
     * @return string
     */
    public function getBillieCode()
    {
        return 'NOT_AUTHORIZED';
    }

    /**
     * @return string
     */
    public function getBillieMessage()
    {
        return $this->message;
    }
}