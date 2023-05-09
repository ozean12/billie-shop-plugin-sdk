<?php
/*
 * Copyright (c) Billie GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Billie\Sdk\Model;

use Billie\Sdk\Util\ResponseHelper;
use DateTime;

/**
 * @method string   getNumber()
 * @method float    getPayoutAmount()
 * @method float    getOutstandingAmount()
 * @method float    getPendingMerchantPaymentAmount()
 * @method float    getPendingCancellationAmount()
 * @method float    getFeeAmount()
 * @method float    getFeeRate()
 * @method DateTime getDueDate()
 */
class Invoice extends AbstractModel
{
    protected ?string $number = null;

    protected ?float $payoutAmount = null;

    protected ?float $outstandingAmount = null;

    protected ?float $pendingMerchantPaymentAmount = null;

    protected ?float $pendingCancellationAmount = null;

    protected ?float $feeAmount = null;

    protected ?float $feeRate = null;

    protected ?DateTime $dueDate = null;

    public function fromArray(array $data): self
    {
        $this->number = ResponseHelper::getString($data, 'invoice_number');
        $this->payoutAmount = ResponseHelper::getFloat($data, 'payout_amount');
        $this->outstandingAmount = ResponseHelper::getFloat($data, 'outstanding_amount');
        $this->pendingMerchantPaymentAmount = ResponseHelper::getFloat($data, 'pending_merchant_payment_amount');
        $this->pendingCancellationAmount = ResponseHelper::getFloat($data, 'pending_cancellation_amount');
        $this->feeAmount = ResponseHelper::getFloat($data, 'fee_amount');
        $this->feeRate = ResponseHelper::getFloat($data, 'fee_rate');
        $this->dueDate = ResponseHelper::getDate($data, 'due_date');

        return $this;
    }
}
