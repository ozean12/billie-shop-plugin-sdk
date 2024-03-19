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
use Billie\Sdk\Model\Request\Invoice\ConfirmPaymentRequestModel;
use Billie\Sdk\Model\Request\InvoiceRequestModel;
use Billie\Sdk\Service\Request\Invoice\CancelInvoiceRequest;
use Billie\Sdk\Service\Request\Invoice\ConfirmPaymentRequest;
use Billie\Sdk\Tests\Functional\Service\Request\AbstractRequestServiceTestCase;

class ConfirmPaymentRequestTest extends AbstractRequestServiceTestCase
{
    protected static bool $serviceMustThrowExceptionOnEmptyResponse = false;

    public function testIfRouteAndMethodIsAsExpected(): void
    {
        $client = $this->createClientExpectParameterMock('invoices/test-invoice-number/confirm-payment', BillieClient::METHOD_POST);

        $requestService = new ConfirmPaymentRequest($client);
        $requestService->execute((new ConfirmPaymentRequestModel('test-invoice-number'))
            ->setPaidAmount(200));
    }

    public function testNotFound(): void
    {
        $requestService = new ConfirmPaymentRequest($this->createClientNotFoundExceptionMock());
        $this->expectException(InvoiceNotFoundException::class);
        $requestService->execute(
            (new ConfirmPaymentRequestModel(''))
                ->setPaidAmount(100)
        );
    }

    protected function getRequestServiceClass(): string
    {
        return ConfirmPaymentRequest::class;
    }
}
