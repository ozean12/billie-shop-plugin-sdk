<?php
/*
 * Copyright (c) Billie GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Billie\Sdk\Model\Request\Invoice;

use Billie\Sdk\Model\Request\InvoiceRequestModel;

/**
 * @method string getInvoiceNumber()
 * @method self   setInvoiceNumber(string $invoiceNumber)
 * @method string getInvoiceUrl()
 * @method self   setInvoiceUrl(string $invoiceUrl)
 */
class UpdateInvoiceRequestModel extends InvoiceRequestModel
{
    protected string $invoiceNumber;

    protected string $invoiceUrl;

    protected function _toArray(): array
    {
        return [
            'external_code' => $this->invoiceNumber,
            'invoice_url' => $this->invoiceUrl,
        ];
    }
}
