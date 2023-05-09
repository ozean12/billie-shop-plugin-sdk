<?php
/*
 * Copyright (c) Billie GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Billie\Sdk\Tests\Functional\Service\Request;

use Billie\Sdk\HttpClient\BillieClient;
use Billie\Sdk\Model\Amount;
use Billie\Sdk\Model\Order;
use Billie\Sdk\Model\Request\OrderRequestModel;
use Billie\Sdk\Model\Request\UpdateOrderRequestModel;
use Billie\Sdk\Service\Request\CreateOrderRequest;
use Billie\Sdk\Service\Request\Order\GetOrderRequest;
use Billie\Sdk\Service\Request\UpdateOrderRequest;
use Billie\Sdk\Tests\Helper\BillieClientHelper;
use Billie\Sdk\Tests\Helper\OrderHelper;

class UpdateOrderTest extends AbstractOrderRequest
{
    private Order $createdOrderModel;

    private BillieClient $client;

    protected function setUp(): void
    {
        $this->client = BillieClientHelper::getClient();
        $this->createdOrderModel = (new CreateOrderRequest($this->client))
            ->execute(
                OrderHelper::createValidOrderModel()
                    ->setExternalCode(null)
            );
        $this->orderIds[] = $this->createdOrderModel->getUuid();
    }

    public function testUpdateOrder(): void
    {
        $externalCode = OrderHelper::getUniqueOrderNumber($this->getName()) . '-updated';
        $requestService = new UpdateOrderRequest($this->client);
        $result = $requestService->execute(
            (new UpdateOrderRequestModel($this->createdOrderModel->getUuid()))
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
}
