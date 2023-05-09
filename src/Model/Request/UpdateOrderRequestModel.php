<?php
/*
 * Copyright (c) Billie GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Billie\Sdk\Model\Request;

use Billie\Sdk\Model\Amount;

/**
 * @method int|null    getDuration()
 * @method self        setDuration(?int $duration)
 * @method string|null getInvoiceNumber()
 * @method self        setInvoiceNumber(?string $invoiceNumber)
 * @method string|null getInvoiceUrl()
 * @method self        setInvoiceUrl(?string $invoiceUrl)
 * @method string|null getOrderId()
 * @method self        setOrderId(?string $orderId)
 * @method Amount|null getAmount()
 * @method self        setAmount(?Amount $amount)
 */
class UpdateOrderRequestModel extends OrderRequestModel
{
    protected ?string $invoiceUrl = null;

    protected ?string $invoiceNumber = null;

    protected ?string $orderId = null;

    protected ?int $duration = null;

    protected ?Amount $amount = null;

    public function getFieldValidations(): array
    {
        return array_merge(parent::getFieldValidations(), [
            'duration' => '?integer',
            'amount' => '?' . Amount::class,
            'invoiceNumber' => '?string',
            'invoiceUrl' => '?url',
            'orderId' => '?string',
        ]);
    }

    public function toArray(): array
    {
        return array_merge(parent::toArray(), [
            'duration' => $this->getDuration(),
            'amount' => $this->getAmount() instanceof Amount ? $this->getAmount()->toArray() : null,
            'invoice_number' => $this->getInvoiceNumber(),
            'invoice_url' => $this->getInvoiceUrl(),
            'order_id' => $this->getOrderId(),
        ]);
    }
}
