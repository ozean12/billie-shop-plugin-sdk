<?php

namespace Billie\Sdk\Service\Request;

use Billie\Sdk\HttpClient\BillieClient;
use Billie\Sdk\Model\Order;
use Billie\Sdk\Model\Request\AbstractRequestModel;
use Billie\Sdk\Model\Request\OrderRequestModel;
use Billie\Sdk\Model\Request\ShipOrderRequestModel;
use InvalidArgumentException;

/**
 * @method Order execute(OrderRequestModel $requestModel)
 */
class ShipOrderRequest extends AbstractRequest
{
    protected function getPath(AbstractRequestModel $requestModel)
    {
        if ($requestModel instanceof ShipOrderRequestModel) {
            return 'order/' . $requestModel->getId() . '/ship';
        }
        throw new InvalidArgumentException('argument must be instance of ' . ShipOrderRequestModel::class);
    }

    protected function processSuccess(AbstractRequestModel $requestModel, $responseData)
    {
        return new Order($responseData);
    }

    protected function getMethod(AbstractRequestModel $requestModel)
    {
        return BillieClient::METHOD_POST;
    }
}
