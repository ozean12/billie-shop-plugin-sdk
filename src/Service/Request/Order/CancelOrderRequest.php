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
use Billie\Sdk\Model\Request\OrderRequestModel;
use Billie\Sdk\Service\Request\AbstractRequest;

/**
 * @see https://developers.billie.io/#operation/order_cancel
 *
 * @extends AbstractRequest<OrderRequestModel, bool>
 */
class CancelOrderRequest extends AbstractRequest
{
    protected function getPath($requestModel): string
    {
        return 'orders/' . $requestModel->getUuid() . '/cancel';
    }

    protected function getMethod($requestModel): string
    {
        return BillieClient::METHOD_POST;
    }
}
