<?php
/*
 * Copyright (c) Billie GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Billie\Sdk\Tests\Functional\Service\Request;

use Billie\Sdk\Exception\OrderNotFoundException;
use Billie\Sdk\Model\Order;
use Billie\Sdk\Model\Request\OrderRequestModel;
use Billie\Sdk\Service\Request\CreateOrderRequest;
use Billie\Sdk\Service\Request\Order\GetOrderRequest;
use Billie\Sdk\Tests\AbstractTestCase;
use Billie\Sdk\Tests\Helper\BillieClientHelper;
use Billie\Sdk\Tests\Helper\OrderHelper;

class GetOrderTest extends AbstractTestCase
{
    private Order $createdOrderModel;

    protected function setUp(): void
    {
        $this->createdOrderModel = (new CreateOrderRequest(BillieClientHelper::getClient()))
            ->execute(OrderHelper::createValidOrderModel());
    }

    public function testGetOrderDetails(): void
    {
        $requestService = new GetOrderRequest(BillieClientHelper::getClient());
        $order = $requestService->execute(new OrderRequestModel($this->createdOrderModel->getUuid()));
        $this->compareArrays($this->createdOrderModel->toArray(), $order->toArray());
    }

    public function testNotFound(): void
    {
        $referenceId = uniqid('invalid-order-id-', false);
        $requestService = new GetOrderRequest(BillieClientHelper::getClient());
        $this->expectException(OrderNotFoundException::class);
        $requestService->execute(new OrderRequestModel($referenceId));
    }
}
