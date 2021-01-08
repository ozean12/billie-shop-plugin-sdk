<?php

namespace Billie\Sdk\Exception;

/**
 * Class InvalidRequestException
 *
 * @package Billie\Exception
 * @author Marcel Barten <github@m-barten.de>
 */
class InvalidRequestException extends BillieException
{

    /**
     * @return string
     */
    public function getBillieCode()
    {
        return 'INVALID_REQUEST';
    }

}