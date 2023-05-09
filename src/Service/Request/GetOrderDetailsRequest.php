<?php

declare(strict_types=1);

namespace Billie\Sdk\Service\Request;

use Billie\Sdk\Model\Order;
use Billie\Sdk\Model\Request\AbstractRequestModel;
use Billie\Sdk\Model\Request\OrderRequestModel;
use InvalidArgumentException;
use RuntimeException;

/**
 * @see https://developers.billie.io/#operation/order_get_details
 *
 * @method Order execute(OrderRequestModel $requestModel)
 */
class GetOrderDetailsRequest extends AbstractRequest
{
    protected function getPath(AbstractRequestModel $requestModel): string
    {
        if ($requestModel instanceof OrderRequestModel) {
            return 'order/' . $requestModel->getId();
        }

        throw new InvalidArgumentException('argument must be instance of ' . OrderRequestModel::class);
    }

    protected function processSuccess(AbstractRequestModel $requestModel, ?array $responseData = null): Order
    {
        if ($responseData === null || $responseData === []) {
            throw new RuntimeException('Unknown error. Not empty response was expected.');
        }

        return new Order($responseData);
    }
}
