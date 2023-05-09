<?php

declare(strict_types=1);

namespace Billie\Sdk\Service\Request;

use Billie\Sdk\Model\Request\AbstractRequestModel;
use Billie\Sdk\Model\Request\CreateSessionRequestModel;
use Billie\Sdk\Model\Response\CreateSessionResponseModel;
use RuntimeException;

/**
 * @see https://developers.billie.io/#operation/checkout_session_create
 *
 * @method CreateSessionResponseModel execute(CreateSessionRequestModel $requestModel)
 */
class CreateSessionRequest extends AbstractRequest
{
    protected function processSuccess(AbstractRequestModel $requestModel, ?array $responseData = null): CreateSessionResponseModel
    {
        if ($responseData === null || $responseData === []) {
            throw new RuntimeException('Unknown error. Not empty response was expected.');
        }

        return new CreateSessionResponseModel($responseData);
    }

    protected function getPath(AbstractRequestModel $requestModel): string
    {
        return '/checkout-session';
    }
}
