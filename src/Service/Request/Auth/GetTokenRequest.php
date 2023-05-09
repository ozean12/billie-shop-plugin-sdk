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
use Billie\Sdk\HttpClient\BillieClient;
use Billie\Sdk\Model\Request\Auth\GetTokenRequestModel;
use Billie\Sdk\Model\Response\Auth\GetTokenResponseModel;
use Billie\Sdk\Service\Request\AbstractRequest;

/**
 * @see https://developers.billie.io/#operation/oauth_token_create
 *
 * @extends AbstractRequest<GetTokenRequestModel, GetTokenResponseModel>
 */
class GetTokenRequest extends AbstractRequest
{
    public function __construct(bool $isSandbox = false)
    {
        parent::__construct();
        $this->setSandbox($isSandbox);
    }

    public function setSandbox(bool $isSandbox): void
    {
        $this->setClient(new BillieClient(null, $isSandbox));
    }

    protected function processSuccess($requestModel, ?array $responseData = null): GetTokenResponseModel
    {
        if ($responseData === null || $responseData === []) {
            throw new InvalidResponseException('Got no response from gateway. A response was expected.');
        }

        return new GetTokenResponseModel($responseData);
    }

    protected function getPath($requestModel): string
    {
        return '/oauth/token';
    }

    protected function getMethod($requestModel): string
    {
        return BillieClient::METHOD_POST;
    }

    protected function isAuthorisationRequired($requestModel): bool
    {
        return false;
    }
}
