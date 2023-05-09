<?php

declare(strict_types=1);

namespace Billie\Sdk\Service\Request;

use Billie\Sdk\Model\Request\GetLegalFormsRequestModel;
use Billie\Sdk\Model\Response\GetLegalFormsResponseModel;
use RuntimeException;

/**
 * @see https://developers.billie.io/#operation/get_legal_forms
 *
 * @extends AbstractRequest<GetLegalFormsRequestModel, GetLegalFormsResponseModel>
 */
class GetLegalFormsRequest extends AbstractRequest
{
    protected bool $cacheable = true;

    protected function processSuccess($requestModel, ?array $responseData = null): GetLegalFormsResponseModel
    {
        if ($responseData === null || $responseData === []) {
            throw new RuntimeException('Unknown error. Not empty response was expected.');
        }

        return new GetLegalFormsResponseModel($responseData);
    }

    protected function getPath($requestModel): string
    {
        return '/legal-forms';
    }

    /**
     * @noinspection SenselessMethodDuplicationInspection
     */
    protected function isAuthorisationRequired($requestModel): bool
    {
        // NOTE: the documentation says that no authentication is needed. But it is needed. (2020-12-29)
        return true;
    }
}
