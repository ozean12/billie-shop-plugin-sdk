<?php
/*
 * Copyright (c) Billie GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Billie\Sdk\Service\Request;

use Billie\Sdk\Exception\InvalidResponseException;
use Billie\Sdk\Model\Request\GetLegalFormsRequestModel;
use Billie\Sdk\Model\Response\GetLegalFormsResponseModel;

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
            throw new InvalidResponseException('Got no response from gateway. A response was expected.');
        }

        return new GetLegalFormsResponseModel($responseData);
    }

    protected function getPath($requestModel): string
    {
        return '/legal-forms';
    }

    protected function isAuthorisationRequired($requestModel): bool
    {
        return false;
    }
}
