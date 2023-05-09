<?php

declare(strict_types=1);

namespace Billie\Sdk\Service\Request;

use Billie\Sdk\HttpClient\BillieClient;
use Billie\Sdk\Model\Order;
use Billie\Sdk\Model\Request\CheckoutSessionConfirmRequestModel;
use RuntimeException;

/**
 * @see https://developers.billie.io/#operation/checkout_session_confirm
 * @extends AbstractRequest<CheckoutSessionConfirmRequestModel, Order>
 */
class CheckoutSessionConfirmRequest extends AbstractRequest
{
    protected function getPath($requestModel): string
    {
        return 'checkout-session/' . $requestModel->getSessionUuid() . '/confirm';
    }

    protected function processSuccess($requestModel, ?array $responseData = null): Order
    {
        if ($responseData === null || $responseData === []) {
            throw new RuntimeException('Unknown error. Not empty response was expected.');
        }

        return new Order($responseData);
    }

    protected function getMethod($requestModel): string
    {
        return BillieClient::METHOD_PUT;
    }
}
