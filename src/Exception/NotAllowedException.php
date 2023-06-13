<?php
/*
 * Copyright (c) Billie GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Billie\Sdk\Exception;

class NotAllowedException extends GatewayException
{
    public function __construct(int $httpCode, array $responseData = [], array $requestData = [])
    {
        parent::__construct('This action is not allowed.', $httpCode, $responseData, $requestData);
    }

    public function getBillieCode(): string
    {
        return 'NOT_ALLOWED';
    }
}
