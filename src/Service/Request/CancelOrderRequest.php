<?php

declare(strict_types=1);

namespace Billie\Sdk\Service\Request;

use Billie\Sdk\HttpClient\BillieClient;
use Billie\Sdk\Model\Request\OrderRequestModel;

/**
 * @see https://developers.billie.io/#operation/order_cancel
 *
 * @extends AbstractRequest<OrderRequestModel, bool>
 */
class CancelOrderRequest extends AbstractRequest
{
    protected function getPath($requestModel): string
    {
        return 'order/' . $requestModel->getId() . '/cancel';
    }

    protected function getMethod($requestModel): string
    {
        return BillieClient::METHOD_POST;
    }
}
