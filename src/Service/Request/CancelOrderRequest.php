<?php

declare(strict_types=1);

namespace Billie\Sdk\Service\Request;

use Billie\Sdk\HttpClient\BillieClient;
use Billie\Sdk\Model\Request\AbstractRequestModel;
use Billie\Sdk\Model\Request\OrderRequestModel;
use InvalidArgumentException;

/**
 * @see https://developers.billie.io/#operation/order_cancel
 *
 * @method bool execute(OrderRequestModel $requestModel)
 */
class CancelOrderRequest extends AbstractRequest
{
    protected function getPath(AbstractRequestModel $requestModel): string
    {
        if ($requestModel instanceof OrderRequestModel) {
            return 'order/' . $requestModel->getId() . '/cancel';
        }

        throw new InvalidArgumentException('argument must be instance of ' . OrderRequestModel::class);
    }

    protected function getMethod(AbstractRequestModel $requestModel): string
    {
        return BillieClient::METHOD_POST;
    }
}
