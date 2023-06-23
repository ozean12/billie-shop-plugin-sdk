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
use Billie\Sdk\Model\Amount;
use Billie\Sdk\Model\Request\Invoice\CreateCreditNoteRequestModel;
use Billie\Sdk\Model\Request\Invoice\LineItem;
use Billie\Sdk\Service\Request\Invoice\CreateCreditNoteRequest;

class CreateCreditNoteRequestTest extends AbstractInvoice
{
    public function testCreateNote(): void
    {
        $invoice = $this->getInvoice(__FUNCTION__);

        $data = (new CreateCreditNoteRequestModel($invoice->getUuid(), $invoice->getNumber()))
            ->setAmount(
                (new Amount())
                    ->setGross(200)
                    ->setNet(round(200 - 200 / 1.19, 2))
            )
            ->setLineItems([
                new LineItem('product-id-1', 2),
                new LineItem('product-id-2', 1),
            ])
            ->setComment('greetings from phpunit');

        $response = (new CreateCreditNoteRequest($this->client))->execute($data);
        self::assertNotNull($response);
    }

    public function testCreateCreditNoteNotFound(): void
    {
        $this->expectException(InvoiceNotFoundException::class);

        $requestService = new CreateCreditNoteRequest($this->client);
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
