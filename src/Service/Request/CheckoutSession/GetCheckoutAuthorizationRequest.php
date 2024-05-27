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
use Billie\Sdk\Model\Request\CheckoutSession\GetCheckoutAuthorizationRequestModel;
use Billie\Sdk\Model\Response\CheckoutSession\GetCheckoutAuthorizationResponseModel;
use Billie\Sdk\Service\Request\AbstractRequest;

/**
 * @see https://docs.billie.io/reference/get_checkout_session_authorization_v2
 *
 * @extends AbstractRequest<GetCheckoutAuthorizationRequestModel, GetCheckoutAuthorizationResponseModel>
 */
class GetCheckoutAuthorizationRequest extends AbstractRequest
{
    protected function getPath($requestModel): string
    {
        return sprintf('checkout-sessions/%s/authorization', $requestModel->getSessionUuid());
    }

    protected function processSuccess($requestModel, ?array $responseData = null): GetCheckoutAuthorizationResponseModel
    {
        if ($responseData === null || $responseData === []) {
            throw new InvalidResponseException('Got no response from gateway. A response was expected.');
        }

        return new GetCheckoutAuthorizationResponseModel($responseData);
    }

    protected function getMethod($requestModel): string
    {
        return BillieClient::METHOD_GET;
    }
}
