<?php
/*
 * Copyright (c) Billie GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Billie\Sdk\Service\Request\Auth;

use Billie\Sdk\HttpClient\BillieClient;
use Billie\Sdk\Model\Request\Auth\RevokeTokenRequestModel;
use Billie\Sdk\Service\Request\AbstractRequest;

/**
 * @see https://docs.billie.io/reference/oauth_token_revoke
 * @extends AbstractRequest<RevokeTokenRequestModel, bool>
 */
class RevokeTokenRequest extends AbstractRequest
{
    protected function processSuccess($requestModel, ?array $responseData = null): bool
    {
        return true;
    }

    protected function getPath($requestModel): string
    {
        return '/oauth/token/revoke';
    }

    protected function getMethod($requestModel): string
    {
        return BillieClient::METHOD_POST;
    }
}
