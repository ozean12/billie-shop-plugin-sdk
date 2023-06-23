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
use Billie\Sdk\Model\Request\InvoiceRequestModel;
use Billie\Sdk\Service\Request\Invoice\CancelInvoiceRequest;

class CancelInvoiceRequestTest extends AbstractInvoice
{
    protected static bool $serviceMustThrowExceptionOnEmptyResponse = false;

    public function testCancelInvoice(): void
    {
        $invoiceUuid = $this->generateInvoice(__FUNCTION__);

        $requestService = new CancelInvoiceRequest($this->client);
        $response = $requestService->execute(new InvoiceRequestModel($invoiceUuid));

        static::assertTrue($response);
    }

    public function testNotFound(): void
    {
        $referenceId = '999d0999-9999-9999-9305-c6eaea2550a6';
        $requestService = new CancelInvoiceRequest($this->client);
        $this->expectException(InvoiceNotFoundException::class);
        $requestService->execute(new InvoiceRequestModel($referenceId));
    }

    protected function getRequestServiceClass(): string
    {
        return CancelInvoiceRequest::class;
    }
}
