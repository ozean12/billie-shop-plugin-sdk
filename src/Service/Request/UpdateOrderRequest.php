<?php

declare(strict_types=1);

namespace Billie\Sdk\Service\Request;

use Billie\Sdk\HttpClient\BillieClient;
use Billie\Sdk\Model\Request\UpdateOrderRequestModel;

/**
 * @see https://developers.billie.io/#operation/order_update
 *
 * @extends AbstractRequest<UpdateOrderRequestModel, bool>
 */
class UpdateOrderRequest extends AbstractRequest
{
    protected function getPath($requestModel): string
    {
        return 'order/' . $requestModel->getId();
    }

    protected function getMethod($requestModel): string
    {
        return BillieClient::METHOD_PATCH;
    }
}
