<?php
/*
 * Copyright (c) Billie GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Billie\Sdk\Tests\Functional\Service\Request;

use Billie\Sdk\Model\Order;
use Billie\Sdk\Model\Request\ShipOrderRequestModel;
use Billie\Sdk\Model\Request\UpdateOrderRequestModel;
use Billie\Sdk\Service\Request\CreateOrderRequest;
use Billie\Sdk\Service\Request\ShipOrderRequest;
use Billie\Sdk\Service\Request\UpdateOrderRequest;
use Billie\Sdk\Tests\AbstractTestCase;
use Billie\Sdk\Tests\Helper\BillieClientHelper;
use Billie\Sdk\Tests\Helper\OrderHelper;

class UpdateOrderTest extends AbstractTestCase
{
    private Order $createdOrderModel;

    protected function setUp(): void
    {
        $this->createdOrderModel = (new CreateOrderRequest(BillieClientHelper::getClient()))
            ->execute(OrderHelper::createValidOrderModel());

        $this->createdOrderModel = (new ShipOrderRequest(BillieClientHelper::getClient()))
            ->execute(
                (new ShipOrderRequestModel($this->createdOrderModel->getUuid()))
                    ->setInvoiceUrl('https://old.domain.com/invoice.pdf')
                    ->setInvoiceNumber(uniqid('invoice-number-', true))
            );
    }

    public function testUpdate(): void
    {
        $invoiceNumber = uniqid('updated-invoice-number-', true);
        $requestService = new UpdateOrderRequest(BillieClientHelper::getClient());
        $result = $requestService->execute(
            (new UpdateOrderRequestModel($this->createdOrderModel->getUuid()))
                ->setInvoiceUrl('https://www.domain.com/invoice.pdf')
                ->setInvoiceNumber($invoiceNumber)
// TODO this two values will be declined by the gateway. issue has been already reported.
//                ->setOrderId($orderId)
//                ->setAmount((new Amount())->setGross(20)->setTaxRate(10))
                ->setDuration(40)
        );

        static::assertTrue($result);
    }
}
