<?php
/*
 * Copyright (c) Billie GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Billie\Sdk\Service\Request\Invoice;

use Billie\Sdk\Exception\InvoiceNotFoundException;
use Billie\Sdk\HttpClient\BillieClient;
use Billie\Sdk\Model\Invoice;
use Billie\Sdk\Model\Request\Invoice\UpdateInvoiceRequestModel;
use Billie\Sdk\Service\Request\AbstractRequest;

/**
 * @see https://docs.billie.io/reference/invoice_update
 * @extends AbstractRequest<UpdateInvoiceRequestModel, bool>
 */
class UpdateInvoiceRequest extends AbstractRequest
{
    protected function getPath($requestModel): string
    {
        return 'invoices/' . $requestModel->getUuid() . '/update-details';
    }

    protected function getNotFoundExceptionClass(): ?string
    {
        return InvoiceNotFoundException::class;
    }

    protected function getMethod($requestModel): string
    {
        return BillieClient::METHOD_POST;
    }
}
