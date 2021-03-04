<?php

namespace Billie\Sdk\Exception;

class NotAllowedException extends GatewayException
{
    public function __construct($httpCode, $responseData = [])
    {
        parent::__construct('This action is not allowed.', $httpCode, $responseData);
    }

    /**
     * @return string
     */
    public function getBillieCode()
    {
        return 'NOT_ALLOWED';
    }
}
