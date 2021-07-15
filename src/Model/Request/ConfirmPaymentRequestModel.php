<?php

namespace Billie\Sdk\Model\Request;

/**
 * @method string|null getPaidAmount()
 * @method self        setPaidAmount(?float $paidAmount)
 */
class ConfirmPaymentRequestModel extends OrderRequestModel
{
    /**
     * @var float
     */
    protected $paidAmount;

    /**
     * {@inheritDoc}
     */
    public function getFieldValidations()
    {
        return array_merge(parent::getFieldValidations(), [
            'paidAmount' => '?float',
        ]);
    }

    /**
     * {@inheritDoc}
     */
    public function toArray()
    {
        return array_merge(parent::toArray(), [
            'paid_amount' => $this->getPaidAmount(),
        ]);
    }
}
