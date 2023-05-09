<?php
/*
 * Copyright (c) Billie GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Billie\Sdk\Exception;

class NotFoundException extends GatewayException
{
    private string $referenceId;

    public function __construct(string $referenceId, int $httpCode, array $responseData = [], array $requestData = [])
    {
        parent::__construct(
            sprintf('The entity with the reference id `%s` does not exist.', $referenceId),
            $httpCode,
            $responseData,
            $requestData
        );
        $this->referenceId = $referenceId;
    }

    public function getReferenceId(): string
    {
        return $this->referenceId;
    }
}
