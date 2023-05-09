<?php

declare(strict_types=1);

namespace Billie\Sdk\Model\Request;

/**
 * @method string|null getPaidAmount()
 * @method self        setPaidAmount(?float $paidAmount)
 */
class ConfirmPaymentRequestModel extends OrderRequestModel
{
    protected ?float $paidAmount = null;

    public function getFieldValidations(): array
    {
        return array_merge(parent::getFieldValidations(), [
            'paidAmount' => '?float',
        ]);
    }

    public function toArray(): array
    {
        return array_merge(parent::toArray(), [
            'paid_amount' => $this->getPaidAmount(),
        ]);
    }
}
