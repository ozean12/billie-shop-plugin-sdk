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
use Billie\Sdk\Model\Amount;
use Billie\Sdk\Model\Request\Invoice\ConfirmPaymentRequestModel;
use Billie\Sdk\Model\Request\Invoice\CreateCreditNoteRequestModel;
use Billie\Sdk\Model\Request\Invoice\LineItem;
use Billie\Sdk\Service\Request\Invoice\ConfirmPaymentRequest;
use Billie\Sdk\Service\Request\Invoice\CreateCreditNoteRequest;
use Billie\Sdk\Tests\Functional\Service\Request\AbstractRequestServiceTestCase;
use Billie\Sdk\Tests\Helper\BillieClientHelper;

class CreateCreditNoteRequestTest extends AbstractRequestServiceTestCase
{
    public function testIfRouteAndMethodIsAsExpected(): void
    {
        $client = $this->createClientExpectParameterMock(
            'invoices/test-invoice-number/credit-notes',
            BillieClient::METHOD_POST,
            [
                'uuid' => 'test-123'
            ]
        );

        $model = (new CreateCreditNoteRequestModel('test-invoice-number', 'credit-note-uuid'))
            ->setAmount(
                (new Amount())
                    ->setGross(200)
                    ->setNet(round(200 - 200 / 1.19, 2))
            )
            ->setLineItems([
                new LineItem('product-id-1', 2),
            ])
            ->setComment('greetings from phpunit');

        (new CreateCreditNoteRequest($client))->execute($model);
    }

    public function testCreateCreditNoteNotFound(): void
    {
        $this->expectException(InvoiceNotFoundException::class);

        $requestService = new CreateCreditNoteRequest(BillieClientHelper::getClient());
        $data = (new CreateCreditNoteRequestModel('5ca8cf79-8223-4515-bdd2-00a9bf6d2dbb', 'external-code'))
            ->setAmount(
                (new Amount())
                    ->setNet(100)
                    ->setGross(119)
            );

        $requestService->execute($data);
    }

    protected function getRequestServiceClass(): string
    {
        return CreateCreditNoteRequest::class;
    }
}
