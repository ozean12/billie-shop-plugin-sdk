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
use Billie\Sdk\Model\Request\Invoice\ConfirmPaymentRequestModel;
use Billie\Sdk\Service\Request\AbstractRequest;

/**
 * @see https://docs.billie.io/reference/invoice_payment_confirm
 * @extends AbstractRequest<ConfirmPaymentRequestModel, bool>
 */
class ConfirmPaymentRequest extends AbstractRequest
{
    protected function getPath($requestModel): string
    {
        return 'invoices/' . $requestModel->getUuid() . '/confirm-payment';
    }

    protected function getMethod($requestModel): string
    {
        return BillieClient::METHOD_POST;
    }

    protected function getNotFoundExceptionClass(): ?string
    {
        return InvoiceNotFoundException::class;
    }
}
