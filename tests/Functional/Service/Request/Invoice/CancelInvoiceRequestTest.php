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
use Billie\Sdk\Service\Request\Invoice\CancelInvoiceRequest;
use Billie\Sdk\Tests\Functional\Service\Request\AbstractRequestServiceTestCase;

class CancelInvoiceRequestTest extends AbstractRequestServiceTestCase
{
    protected static bool $serviceMustThrowExceptionOnEmptyResponse = false;

    public function testIfRouteAndMethodIsAsExpected(): void
    {
        $client = $this->createClientExpectParameterMock('invoices/test-invoice-number', BillieClient::METHOD_DELETE);

        $requestService = new CancelInvoiceRequest($client);
        $requestService->execute(new InvoiceRequestModel('test-invoice-number'));
    }

    public function testNotFound(): void
    {
        $requestService = new CancelInvoiceRequest($this->createClientNotFoundExceptionMock());
        $this->expectException(InvoiceNotFoundException::class);
        $requestService->execute(new InvoiceRequestModel(''));
    }

    protected function getRequestServiceClass(): string
    {
        return CancelInvoiceRequest::class;
    }
}
