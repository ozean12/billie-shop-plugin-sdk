<?php

namespace Billie\Sdk\Model\Request;

/**
 * @method string getPaidAmount()
 * @method self   setPaidAmount(float $paidAmount)
 */
class ConfirmPaymentRequestModel extends OrderRequestModel
{
    /**
     * @var float
     */
    protected $paidAmount;

    public function getFieldValidations()
    {
        return array_merge(parent::getFieldValidations(), [
            'paidAmount' => '?float',
        ]);
    }

    public function toArray()
    {
        return array_merge(parent::toArray(), [
            'paid_amount' => $this->getPaidAmount(),
        ]);
    }
}
