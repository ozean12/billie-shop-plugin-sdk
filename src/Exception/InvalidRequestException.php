<?php

declare(strict_types=1);

namespace Billie\Sdk\Exception;

class InvalidRequestException extends GatewayException
{
    public function getBillieCode(): string
    {
        return 'INVALID_REQUEST';
    }
}
