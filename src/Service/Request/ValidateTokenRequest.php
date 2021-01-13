<?php


namespace Billie\Sdk\Service\Request;


use Billie\Sdk\Model\Request\AbstractRequestModel;
use Billie\Sdk\Model\Response\ValidateTokenResponse;

/**
 * @link https://developers.billie.io/#operation/oauth_token_validate
 *
 * @method ValidateTokenResponse execute(AbstractRequestModel $requestModel)
 */
class ValidateTokenRequest extends AbstractRequest
{

    protected function processSuccess(AbstractRequestModel $requestModel, $responseData)
    {
        return new ValidateTokenResponse($responseData);
    }

    protected function getPath(AbstractRequestModel $requestModel)
    {
        return '/oauth/authorization';
    }
}