<?php

declare(strict_types=1);

namespace Billie\Sdk\Service\Request;

use Billie\Sdk\HttpClient\BillieClient;
use Billie\Sdk\Model\Order;
use Billie\Sdk\Model\Request\AbstractRequestModel;
use Billie\Sdk\Model\Request\ShipOrderRequestModel;
use InvalidArgumentException;
use RuntimeException;

/**
 * @see https://developers.billie.io/#operation/order_ship
 *
 * @method Order execute(ShipOrderRequestModel $requestModel)
 */
class ShipOrderRequest extends AbstractRequest
{
    protected function getPath(AbstractRequestModel $requestModel): string
    {
        if ($requestModel instanceof ShipOrderRequestModel) {
            return 'order/' . $requestModel->getId() . '/ship';
        }

        throw new InvalidArgumentException('argument must be instance of ' . ShipOrderRequestModel::class);
    }

    protected function processSuccess(AbstractRequestModel $requestModel, ?array $responseData = null): Order
    {
        if ($responseData === null || $responseData === []) {
            throw new RuntimeException('Unknown error. Not empty response was expected.');
        }

        return new Order($responseData);
    }

    protected function getMethod(AbstractRequestModel $requestModel): string
    {
        return BillieClient::METHOD_POST;
    }
}
