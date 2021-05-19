<?php

namespace Billie\Sdk\Exception;

class UserNotAuthorizedException extends GatewayException
{
    public function __construct($httpCode, $responseData = [], $requestData = [])
    {
        parent::__construct(
            'The user is not authorized to perform this action.',
            $httpCode,
            $responseData,
            $requestData
        );
    }

    /**
     * @return string
     */
    public function getBillieCode()
    {
        return 'NOT_AUTHORIZED';
    }
}
