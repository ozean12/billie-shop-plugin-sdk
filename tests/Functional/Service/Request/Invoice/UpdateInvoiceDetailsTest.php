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
use Billie\Sdk\Model\Request\Invoice\UpdateInvoiceRequestModel;
use Billie\Sdk\Model\Request\InvoiceRequestModel;
use Billie\Sdk\Service\Request\Invoice\GetInvoiceRequest;
use Billie\Sdk\Service\Request\Invoice\UpdateInvoiceRequest;

class UpdateInvoiceDetailsTest extends AbstractInvoice
{
    public function testUpdateInvoiceNumberUrl(): void
    {
        $invoiceUuid = $this->generateInvoice();
        $newName = $this->getName() . '-' . microtime(true) . '-updated';

        $requestService = new UpdateInvoiceRequest($this->client);
        $response = $requestService->execute(
            (new UpdateInvoiceRequestModel($invoiceUuid))
                ->setInvoiceNumber($newName)
                ->setInvoiceUrl('https://updated-invoice-url.com/path/to/file.pdf')
        );

        static::assertTrue($response);

        $this->wait();

        $invoice = (new GetInvoiceRequest($this->client))->execute(new InvoiceRequestModel($invoiceUuid));
        static::assertEquals($newName, $invoice->getNumber());
        // info: the gateway do not return the invoice-url. So we can not validate the change.
    }

    public function testUpdateInvoiceNotFound(): void
    {
        $referenceId = '999d0999-9999-9999-9305-c6eaea2550a6';
        $requestModel = (new UpdateInvoiceRequestModel($referenceId))
            ->setInvoiceNumber($this->getName() . '-updated')
            ->setInvoiceUrl('https://updated-invoice-url.com/path/to/file.pdf');

        $this->expectException(InvoiceNotFoundException::class);
        (new UpdateInvoiceRequest($this->client))->execute($requestModel);
    }
}
