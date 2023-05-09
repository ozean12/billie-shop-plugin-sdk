<?php
/*
 * Copyright (c) Billie GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Billie\Sdk\Model;

use Billie\Sdk\Model\Response\AbstractResponseModel;
use Billie\Sdk\Util\ResponseHelper;
use DateTime;

/**
 * @method string   getUuid()
 * @method string   getNumber()
 * @method string   getState()
 * @method float    getPayoutAmount()
 * @method Amount   getAmount()
 * @method float    getOutstandingAmount()
 * @method float    getPendingMerchantPaymentAmount()
 * @method float    getPendingCancellationAmount()
 * @method float    getFeeAmount()
 * @method float    getFeeRate()
 * @method DateTime getDueDate()
 * @method DateTime getCreatedAt()
 */
class Invoice extends AbstractResponseModel
{
    protected ?string $uuid = null;

    protected ?string $number = null;

    protected ?string $state = null;

    protected ?float $payoutAmount = null;

    protected ?Amount $amount = null;

    protected ?float $outstandingAmount = null;

    protected ?float $pendingMerchantPaymentAmount = null;

    protected ?float $pendingCancellationAmount = null;

    protected ?float $feeAmount = null;

    protected ?float $feeRate = null;

    protected ?DateTime $dueDate = null;

    protected ?DateTime $createdAt = null;

    public function fromArray(array $data): self
    {
        $this->uuid = ResponseHelper::getString($data, 'uuid');
        $this->number = ResponseHelper::getString($data, 'invoice_number');
        $this->state = ResponseHelper::getString($data, 'state');
        $this->payoutAmount = ResponseHelper::getFloat($data, 'payout_amount');
        $this->amount = isset($data['amount_net']) ? (new Amount(
            [
                'net' => $data['amount_net'],
                'gross' => $data['amount'],
                'tax' => $data['amount_tax'],
            ],
            $this->readOnly
        )) : null;
        $this->outstandingAmount = ResponseHelper::getFloat($data, 'outstanding_amount');
        $this->pendingMerchantPaymentAmount = ResponseHelper::getFloat($data, 'pending_merchant_payment_amount');
        $this->pendingCancellationAmount = ResponseHelper::getFloat($data, 'pending_cancellation_amount');
        $this->feeAmount = ResponseHelper::getFloat($data, 'fee_amount');
        $this->feeRate = ResponseHelper::getFloat($data, 'fee_rate');
        $this->dueDate = ResponseHelper::getDate($data, 'due_date');
        $this->createdAt = ResponseHelper::getDate($data, 'created_at');

        return $this;
    }
}
