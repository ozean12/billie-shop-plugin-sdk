<?php

namespace Billie\Sdk\Service\Request;

use Billie\Sdk\Model\Request\AbstractRequestModel;
use Billie\Sdk\Model\Request\GetLegalFormsRequestModel;
use Billie\Sdk\Model\Response\GetLegalFormsResponseModel;

/**
 * @see https://developers.billie.io/#operation/get_legal_forms
 *
 * @method GetLegalFormsResponseModel execute(GetLegalFormsRequestModel $requestModel)
 */
class GetLegalFormsRequest extends AbstractRequest
{
    /**
     * @var bool
     */
    protected $cacheable = true;

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
