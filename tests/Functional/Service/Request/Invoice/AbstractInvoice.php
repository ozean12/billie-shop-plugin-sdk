<?php
/*
 * Copyright (c) Billie GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Billie\Sdk\Tests\Functional\Service\Request\Invoice;

use Billie\Sdk\HttpClient\BillieClient;
use Billie\Sdk\Service\Request\Invoice\CreateInvoiceRequest;
use Billie\Sdk\Service\Request\Order\CreateOrderRequest;
use Billie\Sdk\Tests\Functional\Service\Request\AbstractOrderRequest;
use Billie\Sdk\Tests\Helper\BillieClientHelper;
use Billie\Sdk\Tests\Helper\InvoiceHelper;
use Billie\Sdk\Tests\Helper\OrderHelper;

abstract class AbstractInvoice extends AbstractOrderRequest
{
    protected BillieClient $client;

    protected function setUp(): void
    {
        $this->client = BillieClientHelper::getClient();
    }

    protected function generateInvoice(): string
    {
        $createOrderModel = OrderHelper::createValidOrderModel($this->getName());

        // make sure test data has not changed
        static::assertCount(2, $createOrderModel->getLineItems());
        static::assertEquals(200, $createOrderModel->getAmount()->getGross());
        static::assertEquals(round(200 - 200 / 1.19, 2), round($createOrderModel->getAmount()->getTax(), 2));

        $order = (new CreateOrderRequest($this->client))->execute($createOrderModel);
        $this->orderIds[] = $order->getUuid(); // for house-keeping

        $createResponse = (new CreateInvoiceRequest($this->client))->execute(InvoiceHelper::createValidCreateInvoiceModel($order));

        return $createResponse->getUuid();
    }
}
