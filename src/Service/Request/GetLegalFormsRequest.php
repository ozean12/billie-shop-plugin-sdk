<?php

namespace Billie\Sdk\Service\Request;

use Billie\Sdk\Model\Request\AbstractRequestModel;
use Billie\Sdk\Model\Response\GetLegalFormsResponseModel;

/**
 * @see https://developers.billie.io/#operation/order_create
 *
 * @method GetLegalFormsResponseModel execute(AbstractRequestModel $requestModel)
 */
class GetLegalFormsRequest extends AbstractRequest
{
    protected function processSuccess(AbstractRequestModel $requestModel, $responseData)
    {
        return new GetLegalFormsResponseModel($responseData);
    }

    protected function getPath(AbstractRequestModel $requestModel)
    {
        return '/legal-forms';
    }

    /** @noinspection SenselessMethodDuplicationInspection */
    protected function isAuthorisationRequired(AbstractRequestModel $requestModel)
    {
        // NOTE: the documentation says that no authentication is needed. But it is needed. (2020-12-29)
        return true;
    }
}
