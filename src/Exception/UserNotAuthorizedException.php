<?php
/*
 * Copyright (c) Billie GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Billie\Sdk\Exception;

class UserNotAuthorizedException extends GatewayException
{
    public function __construct(int $httpCode, array $responseData = [], array $requestData = [])
    {
        parent::__construct(
            'The user is not authorized to perform this action.',
            $httpCode,
            $responseData,
            $requestData
        );
    }

    public function getBillieCode(): string
    {
        return 'NOT_AUTHORIZED';
    }
}
