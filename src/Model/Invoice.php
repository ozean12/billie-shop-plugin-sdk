<?php

namespace Billie\Sdk\Model;

use Billie\Sdk\Model\Response\AbstractResponseModel;
use Billie\Sdk\Util\ResponseHelper;
use DateTime;

/**
 * @method string getNumber()
 * @method float getPayoutAmount()
 * @method float getOutstandingAmount()
 * @method float getPendingMerchantPaymentAmount()
 * @method float getPendingCancellationAmount()
 * @method float getFeeAmount()
 * @method float getFeeRate()
 * @method DateTime getDueDate()
 *
 */
class Invoice extends AbstractModel
{

    /** @var string */
    protected $number;

    /** @var float */
    protected $payoutAmount;

    /** @var float */
    protected $outstandingAmount;

    /** @var float */
    protected $pendingMerchantPaymentAmount;

    /** @var float */
    protected $pendingCancellationAmount;

    /** @var float */
    protected $feeAmount;

    /** @var float */
    protected $feeRate;

    /** @var DateTime */
    protected $dueDate;


    public function fromArray($data)
    {
        $this->number = ResponseHelper::getValue($data, 'invoice_number');
        $this->payoutAmount = ResponseHelper::getValue($data, 'payout_amount');
        $this->outstandingAmount = ResponseHelper::getValue($data, 'outstanding_amount');
        $this->pendingMerchantPaymentAmount = ResponseHelper::getValue($data, 'pending_merchant_payment_amount');
        $this->pendingCancellationAmount = ResponseHelper::getValue($data, 'pending_cancellation_amount');
        $this->feeAmount = ResponseHelper::getValue($data, 'fee_amount');
        $this->feeRate = ResponseHelper::getValue($data, 'fee_rate');
        $this->dueDate = ResponseHelper::getDate($data, 'due_date');
        return $this;
    }
}