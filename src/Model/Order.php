<?php

namespace Billie\Sdk\Model;

use Billie\Sdk\Model\Response\AbstractResponseModel;
use Billie\Sdk\Util\ResponseHelper;
use DateTime;

/**
 * @method string getOrderId()
 * @method string getUuid()
 * @method string getState()
 * @method string getDeclineReason()
 * @method Amount getAmount()
 * @method int getDuration()
 * @method string getDunningStatus()
 * @method DebtorCompany getCompany()
 * @method BankAccount getBankAccount()
 * @method array getExternalData()
 * @method Address getDeliveryAddress()
 * @method Address getBillingAddress()
 * @method DateTime getCreatedAt()
 * @method DateTime getShippedAt()
 * @method string getDebtorUuid()
 * @method Invoice getInvoice()
 */
class Order extends AbstractResponseModel
{
    const STATE_CREATED = 'created';
    const STATE_DECLINED = 'declined';
    const STATE_SHIPPED = 'shipped';
    const STATE_COMPLETED = 'complete';
    const STATE_LATE = 'late';
    const STATE_PAID_OUT = 'paid_out';
    const STATE_CANCELLED = 'canceled';
    const STATE_PREAPPROVED = 'pre_approved';

    const DECLINED_REASON_RISK_POLICY = 'risk_policy';
    const DECLINED_REASON_RISK_SCORE = 'risk_scoring_failed';
    const DECLINED_REASON_DEBTOR_NOT_IDENTIFIED = 'debtor_not_identified';
    const DECLINED_REASON_INVALID_ADDRESS = 'debtor_address';
    const DECLINED_REASON_DEBTOR_LIMIT_EXCEEDED = 'debtor_limit_exceeded';


    /** @var string */
    protected $orderId;

    /** @var string */
    protected $uuid;

    /** @var string */
    protected $state;

    /** @var string */
    protected $declineReason;

    /** @var Amount */
    protected $amount;

    /** @var integer */
    protected $duration;

    /** @var string */
    protected $dunningStatus;

    /** @var DebtorCompany */
    protected $company;

    /** @var BankAccount */
    protected $bankAccount;

    //TODO
    protected $externalData;

    /** @var Address */
    protected $deliveryAddress;

    /** @var Address */
    protected $billingAddress;

    /** @var DateTime */
    protected $createdAt;

    /** @var DateTime */
    protected $shippedAt;

    /** @var string */
    protected $debtorUuid;

    /** @var Invoice */
    protected $invoice;


    public function fromArray($data)
    {
        $this->orderId = ResponseHelper::getValue($data, 'order_id');
        $this->uuid = ResponseHelper::getValue($data, 'uuid');
        $this->state = ResponseHelper::getValue($data, 'state');
        $this->declineReason = ResponseHelper::getValue($data, 'decline_reason');
        $this->amount = isset($data['amount_net']) ? (new Amount(
            [
                'net' => $data['amount_net'],
                'gross' => $data['amount'],
                'tax' => $data['amount_tax']
            ],
            $this->readOnly
        )) : null;
        $this->duration = ResponseHelper::getValue($data, 'duration');
        $this->orderId = ResponseHelper::getValue($data, 'dunning_status');
        $this->company = ResponseHelper::getObject($data, 'debtor_company', DebtorCompany::class, true);
        $this->bankAccount = ResponseHelper::getObject($data, 'bank_account', BankAccount::class, true);
//        $this->orderId = $data['debtor_external_data'];
        $this->deliveryAddress = ResponseHelper::getObject($data, 'delivery_address', Address::class, true);
        $this->billingAddress = ResponseHelper::getObject($data, 'billing_address', Address::class, true);
        $this->createdAt = ResponseHelper::getDateTime($data, 'created_at');
        $this->shippedAt = ResponseHelper::getDateTime($data, 'shipped_at');
        $this->debtorUuid = ResponseHelper::getValue($data, 'debtor_uuid');
        $this->invoice = ResponseHelper::getObject($data, 'invoice', Invoice::class, true);
        return $this;
    }
}