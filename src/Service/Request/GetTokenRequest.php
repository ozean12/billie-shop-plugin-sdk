<?php

declare(strict_types=1);

namespace Billie\Sdk\Service\Request;

use Billie\Sdk\HttpClient\BillieClient;
use Billie\Sdk\Model\Request\AbstractRequestModel;
use Billie\Sdk\Model\Request\GetTokenRequestModel;
use Billie\Sdk\Model\Response\GetTokenResponseModel;
use RuntimeException;

/**
 * @see https://developers.billie.io/#operation/oauth_token_create
 *
 * @method GetTokenResponseModel execute(GetTokenRequestModel $requestModel)
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

    protected function processSuccess(AbstractRequestModel $requestModel, ?array $responseData = null): GetTokenResponseModel
    {
        if ($responseData === null || $responseData === []) {
            throw new RuntimeException('Unknown error. Not empty response was expected.');
        }

        return new GetTokenResponseModel($responseData);
    }

    protected function getPath(AbstractRequestModel $requestModel): string
    {
        return '/oauth/token';
    }

    protected function getMethod(AbstractRequestModel $requestModel): string
    {
        return BillieClient::METHOD_POST;
    }

    protected function isAuthorisationRequired(AbstractRequestModel $requestModel): bool
    {
        return false;
    }
}
