<?php
/*
 * Copyright (c) Billie GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Billie\Sdk\Tests\Functional\Service\Request\Order;

use Billie\Sdk\Exception\OrderNotFoundException;
use Billie\Sdk\Model\Request\OrderRequestModel;
use Billie\Sdk\Service\Request\Order\CreateOrderRequest;
use Billie\Sdk\Service\Request\Order\GetOrderRequest;
use Billie\Sdk\Tests\Functional\Service\Request\AbstractOrderRequest;
use Billie\Sdk\Tests\Helper\BillieClientHelper;
use Billie\Sdk\Tests\Helper\OrderHelper;

class GetOrderTest extends AbstractOrderRequest
{
    public function testGetOrderDetails(): void
    {
        $orderModel = (new CreateOrderRequest(BillieClientHelper::getClient()))
            ->execute(OrderHelper::createValidOrderModel($this->getName()));
        $this->orderIds[] = $orderModel->getUuid();

        $requestService = new GetOrderRequest(BillieClientHelper::getClient());
        $order = $requestService->execute(new OrderRequestModel($orderModel->getUuid()));
        $this->compareArrays($orderModel->toArray(), $order->toArray());
    }

    public function testNotFound(): void
    {
        $referenceId = uniqid('invalid-order-id-', false);
        $requestService = new GetOrderRequest(BillieClientHelper::getClient());
        $this->expectException(OrderNotFoundException::class);
        $requestService->execute(new OrderRequestModel($referenceId));
    }
}
