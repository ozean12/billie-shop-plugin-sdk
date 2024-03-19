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
use Billie\Sdk\Model\Request\Invoice\UpdateInvoiceRequestModel;
use Billie\Sdk\Model\Request\InvoiceRequestModel;
use Billie\Sdk\Service\Request\Invoice\GetInvoiceRequest;
use Billie\Sdk\Service\Request\Invoice\UpdateInvoiceRequest;
use Billie\Sdk\Tests\Functional\Service\Request\AbstractRequestServiceTestCase;
use Billie\Sdk\Tests\Helper\BillieClientHelper;

class UpdateInvoiceDetailsTest extends AbstractRequestServiceTestCase
{
    protected static bool $serviceMustThrowExceptionOnEmptyResponse = false;

    public function testIfRouteAndMethodIsAsExpected(): void
    {
        $client = $this->createClientExpectParameterMock(
            'invoices/test-invoice-uuid/update-details',
            BillieClient::METHOD_POST
        );

        $requestService = new UpdateInvoiceRequest($client);
        $requestService->execute(
            (new UpdateInvoiceRequestModel('test-invoice-uuid'))
                ->setInvoiceNumber('new-number')
                ->setInvoiceUrl('https://updated-invoice-url.com/path/to/file.pdf')
        );
    }

    public function testUpdateInvoiceNotFound(): void
    {
        $referenceId = '999d0999-9999-9999-9305-c6eaea2550a6';
        $requestModel = (new UpdateInvoiceRequestModel($referenceId))
            ->setInvoiceNumber(__FUNCTION__ . '-updated')
            ->setInvoiceUrl('https://updated-invoice-url.com/path/to/file.pdf');

        $this->expectException(InvoiceNotFoundException::class);
        (new UpdateInvoiceRequest(BillieClientHelper::getClient()))->execute($requestModel);
    }

    protected function getRequestServiceClass(): string
    {
        return UpdateInvoiceRequest::class;
    }
}
