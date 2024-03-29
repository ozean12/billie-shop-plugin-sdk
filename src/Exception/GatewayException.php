<?php
/*
 * Copyright (c) Billie GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Billie\Sdk\Exception;

class GatewayException extends BillieException
{
    private array $responseData = [];

    private array $requestData = [];

    public function __construct(string $defaultMessage, int $httpCode, array $responseData = [], array $requestData = [])
    {
        parent::__construct($defaultMessage, (string) $httpCode);
        $this->responseData = $responseData;
        $this->requestData = $requestData;

        if (isset($responseData['errors']) && (is_countable($responseData['errors']) ? count($responseData['errors']) : 0) === 1) {
            $messages = [];
            $codes = [];
            foreach ($responseData['errors'] as $error) {
                $message = $error['title'];

                if (isset($error['source'])) {
                    $message = $error['source'] . ': ' . $message;
                }

                $messages[] = $message;
                $codes[] = $error['code'];
            }

            $this->message = implode(', ', $messages);
            $this->billieCode = implode(', ', $codes);
        }
    }

    public function getResponseData(): array
    {
        return $this->responseData;
    }

    public function getRequestData(): array
    {
        return $this->requestData;
    }
}
