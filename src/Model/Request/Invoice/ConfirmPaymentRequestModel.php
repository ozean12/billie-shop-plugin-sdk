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
 * @method string|null getPaidAmount()
 * @method $this        setPaidAmount(float $paidAmount)
 */
class ConfirmPaymentRequestModel extends InvoiceRequestModel
{
    protected float $paidAmount;
}
