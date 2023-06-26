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
use Billie\Sdk\Service\Request\Invoice\ConfirmPaymentRequest;

class ConfirmPaymentRequestTest extends AbstractInvoice
{
    protected static bool $serviceMustThrowExceptionOnEmptyResponse = false;

    public function testInvoiceConfirmPayment(): void
    {
        $requestService = new ConfirmPaymentRequest($this->client);

        $invoiceUuid = $this->generateInvoice(__FUNCTION__);

        $response = $requestService->execute(
            (new ConfirmPaymentRequestModel($invoiceUuid))
                ->setPaidAmount(200)
        );

        static::assertTrue($response);

        // note: in a previous version we fetched the invoice to test if the outstanding amount has been decreased.
        // but the outstanding amount got only decreased if the merchant has paid the tx-amount of the order.
    }

    public function testNotFound(): void
    {
        $referenceId = '887061d6-ee82-11ed-a05b-0242ac120003';
        $requestModel = (new ConfirmPaymentRequestModel($referenceId))
            ->setPaidAmount(100);

        $this->expectException(InvoiceNotFoundException::class);
        (new ConfirmPaymentRequest($this->client))->execute($requestModel);
    }

    protected function getRequestServiceClass(): string
    {
        return ConfirmPaymentRequest::class;
    }
}
