<?php

declare(strict_types=1);

namespace Billie\Sdk\Service\Request;

use Billie\Sdk\Model\Order;
use Billie\Sdk\Model\Request\OrderRequestModel;
use RuntimeException;

/**
 * @see https://developers.billie.io/#operation/order_get_details
 * @extends AbstractRequest<OrderRequestModel, Order>
 */
class GetOrderDetailsRequest extends AbstractRequest
{
    protected function getPath($requestModel): string
    {
        return 'order/' . $requestModel->getId();
    }

    protected function processSuccess($requestModel, ?array $responseData = null): Order
    {
        if ($responseData === null || $responseData === []) {
            throw new RuntimeException('Unknown error. Not empty response was expected.');
        }

        return new Order($responseData);
    }
}
