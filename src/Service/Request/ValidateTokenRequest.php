<?php

declare(strict_types=1);

namespace Billie\Sdk\Service\Request;

use Billie\Sdk\Model\Request\ValidateTokenRequestModel;
use Billie\Sdk\Model\Response\ValidateTokenResponse;
use RuntimeException;

/**
 * @see https://developers.billie.io/#operation/oauth_token_validate
 * @extends AbstractRequest<ValidateTokenRequestModel, ValidateTokenResponse>
 */
class ValidateTokenRequest extends AbstractRequest
{
    protected function processSuccess($requestModel, ?array $responseData = null): ValidateTokenResponse
    {
        if ($responseData === null || $responseData === []) {
            throw new RuntimeException('Unknown error. Not empty response was expected.');
        }

        return new ValidateTokenResponse($responseData);
    }

    protected function getPath($requestModel): string
    {
        return '/oauth/authorization';
    }
}
