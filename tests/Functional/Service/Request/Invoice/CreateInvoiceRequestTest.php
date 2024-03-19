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
use Billie\Sdk\HttpClient\BillieClient;
use Billie\Sdk\Model\Amount;
use Billie\Sdk\Model\Request\Invoice\CreateInvoiceRequestModel;
use Billie\Sdk\Service\Request\Invoice\CreateInvoiceRequest;
use Billie\Sdk\Tests\Functional\Service\Request\AbstractRequestServiceTestCase;

class CreateInvoiceRequestTest extends AbstractRequestServiceTestCase
{
    public function testIfRouteAndMethodIsAsExpected(): void
    {
        $client = $this->createClientExpectParameterMock(
            'invoices',
            BillieClient::METHOD_POST
        );

        $model = (new CreateInvoiceRequestModel())
            ->setOrders(['test-order-uuid'])
            ->setInvoiceNumber('test-invoice-number')
            ->setAmount(
                (new Amount())
                    ->setGross(200)
                    ->setTaxRate(19.00)
            )
            ->setInvoiceUrl('https://invoice-url.com/path/to/invoice.pdf');

        try {
            (new CreateInvoiceRequest($client))->execute($model);
        } catch (InvalidResponseException $invalidResponseException) {
            // we did not provide a response, so this exception will be thrown.
        }
    }

    protected function getRequestServiceClass(): string
    {
        return CreateInvoiceRequest::class;
    }
}
