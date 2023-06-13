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
use Billie\Sdk\Model\Invoice;
use Billie\Sdk\Model\Request\InvoiceRequestModel;
use Billie\Sdk\Service\Request\Invoice\CreateInvoiceRequest;
use Billie\Sdk\Service\Request\Invoice\GetInvoiceRequest;
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

    protected function generateInvoice(string $testName): string
    {
        $createOrderModel = OrderHelper::createValidOrderModel($testName);

        // make sure test data has not changed
        static::assertCount(2, $createOrderModel->getLineItems());
        static::assertEquals(200, $createOrderModel->getAmount()->getGross());
        static::assertEquals(round(200 - 200 / 1.19, 2), round($createOrderModel->getAmount()->getTax(), 2));

        $order = (new CreateOrderRequest($this->client))->execute($createOrderModel);
        $this->orderIds[] = $order->getUuid(); // for house-keeping

        $createResponse = (new CreateInvoiceRequest($this->client))->execute(InvoiceHelper::createValidCreateInvoiceModel($order));

        $this->wait();

        return $createResponse->getUuid();
    }

    protected function getInvoice(string $testName, string $uuid = null): Invoice
    {
        if ($uuid === null) {
            $uuid = $this->generateInvoice($testName);
        }

        return (new GetInvoiceRequest($this->client))->execute(new InvoiceRequestModel($uuid));
    }

    protected function wait(): void
    {
        // wait two seconds so the gateway does have time to process the invoice internally
        sleep(2);
    }
}
