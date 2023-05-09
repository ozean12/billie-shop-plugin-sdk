<?php
/*
 * Copyright (c) Billie GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Billie\Sdk\Service\Request\Auth;

use Billie\Sdk\Exception\InvalidResponseException;
use Billie\Sdk\Model\Request\Auth\ValidateTokenRequestModel;
use Billie\Sdk\Model\Response\Auth\ValidateTokenResponse;
use Billie\Sdk\Service\Request\AbstractRequest;

/**
 * @see https://developers.billie.io/#operation/oauth_token_validate
 * @extends AbstractRequest<ValidateTokenRequestModel, ValidateTokenResponse>
 */
class ValidateTokenRequest extends AbstractRequest
{
    protected function processSuccess($requestModel, ?array $responseData = null): ValidateTokenResponse
    {
        if ($responseData === null || $responseData === []) {
            throw new InvalidResponseException('Got no response from gateway. A response was expected.');
        }

        return new ValidateTokenResponse($responseData);
    }

    protected function getPath($requestModel): string
    {
        return '/oauth/authorization';
    }
}
