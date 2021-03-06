<?php

namespace Billie\Sdk\Service\Request;

use Billie\Sdk\HttpClient\BillieClient;
use Billie\Sdk\Model\Request\AbstractRequestModel;
use Billie\Sdk\Model\Request\UpdateOrderRequestModel;
use InvalidArgumentException;

/**
 * @see https://developers.billie.io/#operation/order_update
 *
 * @method bool execute(UpdateOrderRequestModel $requestModel)
 */
class UpdateOrderRequest extends AbstractRequest
{
    protected function getPath(AbstractRequestModel $requestModel)
    {
        if ($requestModel instanceof UpdateOrderRequestModel) {
            return 'order/' . $requestModel->getId();
        }
        throw new InvalidArgumentException('argument must be instance of ' . UpdateOrderRequestModel::class);
    }

    protected function getMethod(AbstractRequestModel $requestModel)
    {
        return BillieClient::METHOD_PATCH;
    }
}
