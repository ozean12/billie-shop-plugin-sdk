<?php


namespace Billie\Sdk\Service\Request;


use Billie\Sdk\Model\Request\AbstractRequestModel;
use Billie\Sdk\Model\Response\CreateSessionResponseModel;

/**
 * @link https://developers.billie.io/#operation/checkout_session_create
 *
 * @method CreateSessionResponseModel execute(AbstractRequestModel $requestModel)
 */
class CreateSessionRequest extends AbstractRequest
{

    protected function processSuccess(AbstractRequestModel $requestModel, $responseData)
    {
        return new CreateSessionResponseModel($responseData);
    }

    protected function getPath(AbstractRequestModel $requestModel)
    {
        return '/checkout-session';
    }
}