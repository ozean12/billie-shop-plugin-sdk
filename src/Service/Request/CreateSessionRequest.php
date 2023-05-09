<?php
/*
 * Copyright (c) Billie GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Billie\Sdk\Service\Request;

use Billie\Sdk\Model\Request\CreateSessionRequestModel;
use Billie\Sdk\Model\Response\CreateSessionResponseModel;
use RuntimeException;

/**
 * @see https://developers.billie.io/#operation/checkout_session_create
 *
 * @extends AbstractRequest<CreateSessionRequestModel, CreateSessionResponseModel>
 */
class CreateSessionRequest extends AbstractRequest
{
    protected function processSuccess($requestModel, ?array $responseData = null): CreateSessionResponseModel
    {
        if ($responseData === null || $responseData === []) {
            throw new RuntimeException('Unknown error. Not empty response was expected.');
        }

        return new CreateSessionResponseModel($responseData);
    }

    protected function getPath($requestModel): string
    {
        return '/checkout-session';
    }
}
