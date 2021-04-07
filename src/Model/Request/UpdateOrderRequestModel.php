<?php

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
    /**
     * @var string
     */
    protected $invoiceUrl;

    /**
     * @var string
     */
    protected $invoiceNumber;

    /**
     * @var string
     */
    protected $orderId;

    /**
     * @var int
     */
    protected $duration;

    /**
     * @var Amount
     */
    protected $amount;

    public function getFieldValidations()
    {
        return array_merge(parent::getFieldValidations(), [
            'duration' => '?integer',
            'amount' => '?' . Amount::class,
            'invoiceNumber' => '?string',
            'invoiceUrl' => '?url',
            'orderId' => '?string',
        ]);
    }

    public function toArray()
    {
        return array_merge(parent::toArray(), [
            'duration' => $this->getDuration(),
            'amount' => $this->getAmount() ? $this->getAmount()->toArray() : null,
            'invoice_number' => $this->getInvoiceNumber(),
            'invoice_url' => $this->getInvoiceUrl(),
            'order_id' => $this->getOrderId(),
        ]);
    }
}
