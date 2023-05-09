<?php
/*
 * Copyright (c) Billie GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Billie\Sdk\Tests\Functional\Service\Request\Invoice;

use Billie\Sdk\Exception\InvoiceNotFoundException;
use Billie\Sdk\HttpClient\BillieClient;
use Billie\Sdk\Model\Request\InvoiceRequestModel;
use Billie\Sdk\Service\Request\CreateOrderRequest;
use Billie\Sdk\Service\Request\Invoice\CreateInvoiceRequest;
use Billie\Sdk\Service\Request\Invoice\GetInvoiceRequest;
use Billie\Sdk\Tests\Functional\Service\Request\AbstractOrderRequest;
use Billie\Sdk\Tests\Helper\BillieClientHelper;
use Billie\Sdk\Tests\Helper\InvoiceHelper;
use Billie\Sdk\Tests\Helper\OrderHelper;

class GetInvoiceRequestTest extends AbstractOrderRequest
{
    private BillieClient $client;

    protected function setUp(): void
    {
        $this->client = BillieClientHelper::getClient();
    }

    public function testGetInvoice(): void
    {
        $invoiceUuid = $this->generateInvoice();

        $requestService = new GetInvoiceRequest($this->client);
        $invoice = $requestService->execute(new InvoiceRequestModel($invoiceUuid));

        static::assertEquals($invoiceUuid, $invoice->getUuid());
        static::assertEquals(200, $invoice->getAmount()->getGross());
    }

    public function testNotFound(): void
    {
        $referenceId = '999d0999-9999-9999-9305-c6eaea2550a6';
        $requestService = new GetInvoiceRequest($this->client);
        $this->expectException(InvoiceNotFoundException::class);
        $requestService->execute(new InvoiceRequestModel($referenceId));
    }

    private function generateInvoice(): string
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
