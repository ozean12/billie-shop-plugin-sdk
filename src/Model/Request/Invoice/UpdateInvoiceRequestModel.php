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
 * @method $this   setInvoiceNumber(string $invoiceNumber)
 * @method string getInvoiceUrl()
 * @method $this   setInvoiceUrl(string $invoiceUrl)
 */
class UpdateInvoiceRequestModel extends InvoiceRequestModel
{
    protected static array $_additionalFieldMapping = [
        'uuid' => false,
        'invoiceNumber' => 'external_code',
    ];

    protected string $invoiceNumber;

    protected string $invoiceUrl;
}
