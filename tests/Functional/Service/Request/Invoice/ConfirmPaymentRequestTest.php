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
use Billie\Sdk\Model\Request\Invoice\ConfirmPaymentRequestModel;
use Billie\Sdk\Model\Request\InvoiceRequestModel;
use Billie\Sdk\Service\Request\Invoice\ConfirmPaymentRequest;
use Billie\Sdk\Service\Request\Invoice\GetInvoiceRequest;

class ConfirmPaymentRequestTest extends AbstractInvoice
{
    public function testInvoiceConfirmPayment(): void
    {
        // TODO confirming payment in sandbox-mode is not possible. CLARIFY
        $requestService = new ConfirmPaymentRequest($this->client);

        $invoiceUuid = $this->generateInvoice();

        $response = $requestService->execute(
            (new ConfirmPaymentRequestModel($invoiceUuid))
                ->setPaidAmount(200)
        );

        static::assertTrue($response);

        $invoice = (new GetInvoiceRequest($this->client))->execute(new InvoiceRequestModel($invoiceUuid));
        static::assertEquals(0, $invoice->getOutstandingAmount());
    }

    public function testInvoiceConfirmPaymentTwoParts(): void
    {
        // TODO confirming payment in sandbox-mode is not possible. CLARIFY
        $requestService = new ConfirmPaymentRequest($this->client);
        $getInvoiceService = new GetInvoiceRequest($this->client);

        $invoiceUuid = $this->generateInvoice();

        // create first payment confirmation
        $response = $requestService->execute(
            (new ConfirmPaymentRequestModel($invoiceUuid))
                ->setPaidAmount(50)
        );
        static::assertTrue($response);

        // validation result of first payment confirmation
        $invoice = $getInvoiceService->execute(new InvoiceRequestModel($invoiceUuid));
        static::assertEquals(150, $invoice->getOutstandingAmount());

        // create second payment confirmation
        $response = $requestService->execute(
            (new ConfirmPaymentRequestModel($invoiceUuid))
                ->setPaidAmount(150)
        );
        static::assertTrue($response);

        // validation result of second payment confirmation
        $invoice = $getInvoiceService->execute(new InvoiceRequestModel($invoiceUuid));
        static::assertEquals(0, $invoice->getOutstandingAmount());
    }

    public function testNotFound(): void
    {
        $referenceId = '887061d6-ee82-11ed-a05b-0242ac120003';
        $requestModel = (new ConfirmPaymentRequestModel($referenceId))
            ->setPaidAmount(100);

        $this->expectException(InvoiceNotFoundException::class);
        (new ConfirmPaymentRequest($this->client))->execute($requestModel);
    }
}
