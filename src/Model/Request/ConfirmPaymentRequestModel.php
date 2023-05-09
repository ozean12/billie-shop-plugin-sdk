<?php
/*
 * Copyright (c) Billie GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

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
