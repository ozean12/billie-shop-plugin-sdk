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
use Billie\Sdk\Model\Request\InvoiceRequestModel;
use Billie\Sdk\Service\Request\Invoice\GetInvoiceRequest;

class GetInvoiceRequestTest extends AbstractInvoice
{
    public function testGetInvoice(): void
    {
        $invoiceUuid = $this->generateInvoice(__FUNCTION__);

        $requestService = new GetInvoiceRequest($this->client);
        $invoice = $requestService->execute(new InvoiceRequestModel($invoiceUuid));

        static::assertEquals($invoiceUuid, $invoice->getUuid());
        static::assertEquals(200, $invoice->getAmount()->getGross());
    }

    public function testNotFound(): void
    {
        $requestService = new GetInvoiceRequest($this->createClientNotFoundExceptionMock());
        $this->expectException(InvoiceNotFoundException::class);
        $requestService->execute((new InvoiceRequestModel('')));
    }

    protected function getRequestServiceClass(): string
    {
        return GetInvoiceRequest::class;
    }
}
