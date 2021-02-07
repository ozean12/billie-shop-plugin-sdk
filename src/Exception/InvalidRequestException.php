<?php

namespace Billie\Sdk\Exception;

class InvalidRequestException extends GatewayException
{

    /**
     * @return string
     */
    public function getBillieCode()
    {
        return 'INVALID_REQUEST';
    }

}