<?php
/*
 * Copyright (c) Billie GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Billie\Sdk\Service\Request;

use Billie\Sdk\Exception\InvalidResponseException;
use Billie\Sdk\HttpClient\BillieClient;
use Billie\Sdk\Model\Order;
use Billie\Sdk\Model\Request\ShipOrderRequestModel;

/**
 * @see https://developers.billie.io/#operation/order_ship
 *
 * @extends AbstractRequest<ShipOrderRequestModel, Order>
 */
class ShipOrderRequest extends AbstractRequest
{
    protected function getPath($requestModel): string
    {
        return 'order/' . $requestModel->getId() . '/ship';
    }

    protected function processSuccess($requestModel, ?array $responseData = null): Order
    {
        if ($responseData === null || $responseData === []) {
            throw new InvalidResponseException('Got no response from gateway. A response was expected.');
        }

        return new Order($responseData);
    }

    protected function getMethod($requestModel): string
    {
        return BillieClient::METHOD_POST;
    }
}
