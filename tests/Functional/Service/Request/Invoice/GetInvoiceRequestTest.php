<?php
/*
 * Copyright (c) Billie GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Billie\Sdk\Tests\Functional\Service\Request\Invoice;

use Billie\Sdk\Exception\InvalidResponseException;
use Billie\Sdk\Exception\InvoiceNotFoundException;
use Billie\Sdk\HttpClient\BillieClient;
use Billie\Sdk\Model\Request\InvoiceRequestModel;
use Billie\Sdk\Service\Request\Invoice\GetInvoiceRequest;
use Billie\Sdk\Tests\Functional\Service\Request\AbstractRequestServiceTestCase;

class GetInvoiceRequestTest extends AbstractRequestServiceTestCase
{
    public function testIfRouteAndMethodIsAsExpected(): void
    {
        $client = $this->createClientExpectParameterMock(
            'invoices/test-invoice-uuid',
            BillieClient::METHOD_GET
        );

        try {
            (new GetInvoiceRequest($client))->execute(new InvoiceRequestModel('test-invoice-uuid'));
        } catch (InvalidResponseException $invalidResponseException) {
            // we did not provide a response, so this exception will be thrown.
        }
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
