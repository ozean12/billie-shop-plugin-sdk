<?php

namespace Billie\Sdk\Exception;

class UserNotAuthorizedException extends GatewayException
{
    public function __construct($httpCode, $responseData = [])
    {
        parent::__construct('The user is not authorized to perform this action.', $httpCode, $responseData);
    }

    /**
     * @return string
     */
    public function getBillieCode()
    {
        return 'NOT_AUTHORIZED';
    }
}