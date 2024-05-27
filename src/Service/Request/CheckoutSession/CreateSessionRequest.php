<?php
/*
 * Copyright (c) Billie GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Billie\Sdk\Service\Request\CheckoutSession;

use Billie\Sdk\Exception\InvalidResponseException;
use Billie\Sdk\HttpClient\BillieClient;
use Billie\Sdk\Model\Request\CheckoutSession\CreateSessionRequestModel;
use Billie\Sdk\Model\Response\CreateSessionResponseModel;
use Billie\Sdk\Service\Request\AbstractRequest;

/**
 * @see https://docs.billie.io/reference/create_checkout_session_v2
 *
 * @extends AbstractRequest<CreateSessionRequestModel, CreateSessionResponseModel>
 */
class CreateSessionRequest extends AbstractRequest
{
    protected function processSuccess($requestModel, ?array $responseData = null): CreateSessionResponseModel
    {
        if ($responseData === null || $responseData === []) {
            throw new InvalidResponseException('Got no response from gateway. A response was expected.');
        }

        return new CreateSessionResponseModel($responseData);
    }

    protected function getPath($requestModel): string
    {
        return '/checkout-sessions';
    }

    protected function getMethod($requestModel): string
    {
        return BillieClient::METHOD_POST;
    }
}
