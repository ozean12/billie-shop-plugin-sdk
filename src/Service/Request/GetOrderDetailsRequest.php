<?php


namespace Billie\Sdk\Service\Request;


use Billie\Sdk\Model\Order;
use Billie\Sdk\Model\Request\AbstractRequestModel;
use Billie\Sdk\Model\Request\OrderRequestModel;
use InvalidArgumentException;

/**
 * @method Order execute(OrderRequestModel $requestModel)
 */
class GetOrderDetailsRequest extends AbstractRequest
{

    protected function getPath(AbstractRequestModel $requestModel)
    {
        if ($requestModel instanceof OrderRequestModel) {
            return 'order/' . $requestModel->getId();
        }
        throw new InvalidArgumentException('argument must be instance of ' . OrderRequestModel::class);
    }

    protected function processSuccess(AbstractRequestModel $requestModel, $responseData)
    {
        return new Order($responseData);
    }
}