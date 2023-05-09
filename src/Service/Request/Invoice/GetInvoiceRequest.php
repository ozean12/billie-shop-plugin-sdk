<?php
/*
 * Copyright (c) Billie GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Billie\Sdk\Service\Request\Invoice;

use Billie\Sdk\Exception\InvalidResponseException;
use Billie\Sdk\Exception\InvoiceNotFoundException;
use Billie\Sdk\HttpClient\BillieClient;
use Billie\Sdk\Model\Invoice;
use Billie\Sdk\Model\Request\InvoiceRequestModel;
use Billie\Sdk\Service\Request\AbstractRequest;

/**
 * @see https://docs.billie.io/reference/get_invoice
 * @extends AbstractRequest<InvoiceRequestModel, Invoice>
 */
class GetInvoiceRequest extends AbstractRequest
{
    protected function getPath($requestModel): string
    {
        return 'invoices/' . $requestModel->getUuid();
    }

    protected function processSuccess($requestModel, ?array $responseData = null): Invoice
    {
        if ($responseData === null) {
            throw new InvalidResponseException('got no response from gateway. A response was expected.');
        }

        return new Invoice($responseData);
    }

    protected function getNotFoundExceptionClass(): ?string
    {
        return InvoiceNotFoundException::class;
    }

    protected function getMethod($requestModel): string
    {
        return BillieClient::METHOD_GET;
    }
}
