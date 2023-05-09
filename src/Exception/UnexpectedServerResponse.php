<?php

declare(strict_types=1);

namespace Billie\Sdk\Exception;

class UnexpectedServerResponse extends GatewayException
{
    /**
     * @param int   $httpCode
     */
    public function __construct($httpCode, array $responseData = [], array $requestData = [])
    {
        parent::__construct(
            $responseData['message'] ?? 'Unknown gateway response',
            $httpCode,
            $responseData,
            $requestData
        );
    }
}
