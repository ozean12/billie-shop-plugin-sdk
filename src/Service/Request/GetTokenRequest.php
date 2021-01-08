<?php


namespace Billie\Sdk\Service\Request;


use Billie\Sdk\HttpClient\BillieClient;
use Billie\Sdk\Model\Request\AbstractRequestModel;
use Billie\Sdk\Model\Response\GetTokenResponseModel;

/**
 * @method GetTokenResponseModel execute(AbstractRequestModel $requestModel)
 */
class GetTokenRequest extends AbstractRequest
{

    /**
     * @noinspection MagicMethodsValidityInspection
     * @noinspection PhpMissingParentConstructorInspection
     * @param bool $isSandbox
     */
    public function __construct($isSandbox)
    {
        $this->client = new BillieClient(null, $isSandbox);
    }

    protected function processSuccess(AbstractRequestModel $requestModel, $responseData)
    {
        return (new GetTokenResponseModel())->fromArray($responseData);
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