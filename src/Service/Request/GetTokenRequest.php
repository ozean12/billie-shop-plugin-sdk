<?php

namespace Billie\Sdk\Service\Request;

use Billie\Sdk\HttpClient\BillieClient;
use Billie\Sdk\Model\Request\AbstractRequestModel;
use Billie\Sdk\Model\Request\GetTokenRequestModel;
use Billie\Sdk\Model\Response\GetTokenResponseModel;

/**
 * @see https://developers.billie.io/#operation/oauth_token_create
 *
 * @method GetTokenResponseModel execute(GetTokenRequestModel $requestModel)
 */
class GetTokenRequest extends AbstractRequest
{
    /**
     * @param bool $isSandbox
     */
    public function __construct($isSandbox = false)
    {
        parent::__construct();
        $this->setSandbox($isSandbox);
    }

    public function setSandbox($isSandbox)
    {
        $this->setClient(new BillieClient(null, $isSandbox));
    }

    protected function processSuccess(AbstractRequestModel $requestModel, $responseData)
    {
        return new GetTokenResponseModel($responseData);
    }

    protected function getPath(AbstractRequestModel $requestModel)
    {
        return '/oauth/token';
    }

    protected function getMethod(AbstractRequestModel $requestModel)
    {
        return BillieClient::METHOD_POST;
    }

    protected function isAuthorisationRequired(AbstractRequestModel $requestModel)
    {
        return false;
    }
}
