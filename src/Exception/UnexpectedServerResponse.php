<?php

namespace Billie\Sdk\Exception;

class UnexpectedServerResponse extends GatewayException
{
    /**
     * @param int   $httpCode
     * @param array $responseData
     * @param array $requestData
     */
    public function __construct($httpCode, $responseData = [], $requestData = [])
    {
        parent::__construct(
            isset($responseData['message']) ? $responseData['message'] : 'Unknown gateway response',
            $httpCode,
            $responseData,
            $requestData
        );
    }
}
