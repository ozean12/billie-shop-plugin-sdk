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
}
