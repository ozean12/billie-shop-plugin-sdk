<?php

namespace Billie\Sdk\Service\Request;

use Billie\Sdk\HttpClient\BillieClient;
use Billie\Sdk\Model\Request\AbstractRequestModel;
use Billie\Sdk\Model\Request\OrderRequestModel;
use InvalidArgumentException;

/**
 * @method bool execute(OrderRequestModel $requestModel)
 */
class CancelOrderRequest extends AbstractRequest
{
    protected function getPath(AbstractRequestModel $requestModel)
    {
        if ($requestModel instanceof OrderRequestModel) {
            return 'order/' . $requestModel->getId() . '/cancel';
        }
        throw new InvalidArgumentException('argument must be instance of ' . OrderRequestModel::class);
    }

    protected function processSuccess(AbstractRequestModel $requestModel, $responseData)
    {
        // there is only a HTTP Code 204 response
        return true;
    }

    protected function getMethod(AbstractRequestModel $requestModel)
    {
        return BillieClient::METHOD_POST;
    }
}
