<?php
/*
 * Copyright (c) Billie GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Billie\Sdk\Service\Request\Order;

use Billie\Sdk\Exception\InvalidResponseException;
use Billie\Sdk\Exception\OrderNotFoundException;
use Billie\Sdk\Model\Order;
use Billie\Sdk\Model\Request\OrderRequestModel;
use Billie\Sdk\Service\Request\AbstractRequest;

/**
 * @see https://docs.billie.io/reference/order_get_details
 * @extends AbstractRequest<OrderRequestModel, Order>
 */
class GetOrderRequest extends AbstractRequest
{
    protected function getPath($requestModel): string
    {
        return 'orders/' . $requestModel->getUuid();
    }

    protected function processSuccess($requestModel, ?array $responseData = null): Order
    {
        if ($responseData === null || $responseData === []) {
            throw new InvalidResponseException('Got no response from gateway. A response was expected.');
        }

        return new Order($responseData);
    }

    protected function getNotFoundExceptionClass(): ?string
    {
        return OrderNotFoundException::class;
    }
}
