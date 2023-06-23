<?php
/*
 * Copyright (c) Billie GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Billie\Sdk\Tests\Functional\Service\Request\Order;

use Billie\Sdk\HttpClient\BillieClient;
use Billie\Sdk\Model\Amount;
use Billie\Sdk\Model\Order;
use Billie\Sdk\Model\Request\Order\UpdateOrderRequestModel;
use Billie\Sdk\Model\Request\OrderRequestModel;
use Billie\Sdk\Service\Request\Order\CreateOrderRequest;
use Billie\Sdk\Service\Request\Order\GetOrderRequest;
use Billie\Sdk\Service\Request\Order\UpdateOrderRequest;
use Billie\Sdk\Tests\Functional\Service\Request\AbstractOrderRequest;
use Billie\Sdk\Tests\Helper\BillieClientHelper;
use Billie\Sdk\Tests\Helper\OrderHelper;

class UpdateOrderTest extends AbstractOrderRequest
{
    protected static bool $serviceMustThrowExceptionOnEmptyResponse = false;

    private Order $createdOrderModel;

    private BillieClient $client;

    protected function setUp(): void
    {
        $this->client = BillieClientHelper::getClient();
    }

    public function testUpdateOrder(): void
    {
        $order = $this->createOrder();
        $externalCode = OrderHelper::getUniqueOrderNumber(__METHOD__) . '-updated';
        $requestService = new UpdateOrderRequest($this->client);
        $result = $requestService->execute(
            (new UpdateOrderRequestModel($order->getUuid()))
                ->setExternalCode($externalCode)
                ->setAmount(
                    (new Amount())
                        ->setGross(119)
                        ->setTaxRate(19)
                )
        );

        static::assertTrue($result);

        $fetchedOrder = (new GetOrderRequest($this->client))
            ->execute(new OrderRequestModel($this->createdOrderModel->getUuid()));

        static::assertEquals($externalCode, $fetchedOrder->getExternalCode());
        static::assertEquals(119, $fetchedOrder->getAmount()->getGross());
        static::assertEquals(100, $fetchedOrder->getAmount()->getNet());
        static::assertEquals(19, $fetchedOrder->getAmount()->getTax());
    }

    protected function getRequestServiceClass(): string
    {
        return UpdateOrderRequest::class;
    }

    private function createOrder(): Order
    {
        $this->createdOrderModel = (new CreateOrderRequest($this->client))
            ->execute(
                OrderHelper::createValidOrderModel()
                    ->setExternalCode(null)
            );
        $this->orderIds[] = $this->createdOrderModel->getUuid();

        return $this->createdOrderModel;
    }
}
