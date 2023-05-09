<?php
/*
 * Copyright (c) Billie GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Billie\Sdk\Service\Request\Order;

use Billie\Sdk\HttpClient\BillieClient;
use Billie\Sdk\Model\Request\Order\UpdateOrderRequestModel;
use Billie\Sdk\Service\Request\AbstractRequest;

/**
 * @see https://developers.billie.io/#operation/order_update
 *
 * @extends AbstractRequest<UpdateOrderRequestModel, bool>
 */
class UpdateOrderRequest extends AbstractRequest
{
    protected function getPath($requestModel): string
    {
        return 'orders/' . $requestModel->getUuid();
    }

    protected function getMethod($requestModel): string
    {
        return BillieClient::METHOD_POST;
    }
}
