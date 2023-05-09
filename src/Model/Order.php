<?php

declare(strict_types=1);

namespace Billie\Sdk\Model;

use Billie\Sdk\Model\Response\AbstractResponseModel;
use Billie\Sdk\Util\ResponseHelper;
use DateTime;

/**
 * @method string        getOrderId()
 * @method string        getUuid()
 * @method string        getState()
 * @method string        getDeclineReason()
 * @method Amount        getAmount()
 * @method int           getDuration()
 * @method string        getDunningStatus()
 * @method DebtorCompany getCompany()
 * @method BankAccount   getBankAccount()
 * @method array         getExternalData()
 * @method Address       getDeliveryAddress()
 * @method Address       getBillingAddress()
 * @method DateTime      getCreatedAt()
 * @method DateTime      getShippedAt()
 * @method string        getDebtorUuid()
 * @method Invoice       getInvoice()
 */
class Order extends AbstractResponseModel
{
    /**
     * @var string
     */
    public const STATE_CREATED = 'created';

    /**
     * @var string
     */
    public const STATE_DECLINED = 'declined';

    /**
     * @var string
     */
    public const STATE_SHIPPED = 'shipped';

    /**
     * @var string
     */
    public const STATE_COMPLETED = 'complete';

    /**
     * @var string
     */
    public const STATE_LATE = 'late';

    /**
     * @var string
     */
    public const STATE_PAID_OUT = 'paid_out';

    /**
     * @var string
     */
    public const STATE_CANCELLED = 'canceled';

    /**
     * @var string
     */
    public const STATE_PREAPPROVED = 'pre_approved';

    /**
     * @var string
     */
    public const DECLINED_REASON_RISK_POLICY = 'risk_policy';

    /**
     * @var string
     */
    public const DECLINED_REASON_RISK_SCORE = 'risk_scoring_failed';

    /**
     * @var string
     */
    public const DECLINED_REASON_DEBTOR_NOT_IDENTIFIED = 'debtor_not_identified';

    /**
     * @var string
     */
    public const DECLINED_REASON_INVALID_ADDRESS = 'debtor_address';

    /**
     * @var string
     */
    public const DECLINED_REASON_DEBTOR_LIMIT_EXCEEDED = 'debtor_limit_exceeded';

    protected ?string $orderId = null;

    protected ?string $uuid = null;

    protected ?string $state = null;

    protected ?string $declineReason = null;

    protected ?Amount $amount = null;

    protected ?int $duration = null;

    protected ?string $dunningStatus = null;

    protected ?DebtorCompany $company = null;

    protected ?BankAccount $bankAccount = null;

    protected ?array $externalData = [];

    protected ?Address $deliveryAddress = null;

    protected ?Address $billingAddress = null;

    protected ?DateTime $createdAt = null;

    protected ?DateTime $shippedAt = null;

    protected ?string $debtorUuid = null;

    protected ?Invoice $invoice = null;

    public function fromArray(array $data): self
    {
        $this->orderId = ResponseHelper::getString($data, 'order_id');
        $this->uuid = ResponseHelper::getString($data, 'uuid');
        $this->state = ResponseHelper::getString($data, 'state');
        $this->declineReason = ResponseHelper::getString($data, 'decline_reason');
        $this->amount = isset($data['amount_net']) ? (new Amount(
            [
                'net' => $data['amount_net'],
                'gross' => $data['amount'],
                'tax' => $data['amount_tax'],
            ],
            $this->readOnly
        )) : null;
        $this->duration = ResponseHelper::getInt($data, 'duration');
        $this->orderId = ResponseHelper::getString($data, 'dunning_status');
        $this->company = ResponseHelper::getObject($data, 'debtor_company', DebtorCompany::class, true);
        $this->bankAccount = ResponseHelper::getObject($data, 'bank_account', BankAccount::class, true);
        //        $this->orderId = $data['debtor_external_data'];
        $this->deliveryAddress = ResponseHelper::getObject($data, 'delivery_address', Address::class, true);
        $this->billingAddress = ResponseHelper::getObject($data, 'billing_address', Address::class, true);
        $this->createdAt = ResponseHelper::getDateTime($data, 'created_at');
        $this->shippedAt = ResponseHelper::getDateTime($data, 'shipped_at');
        $this->debtorUuid = ResponseHelper::getString($data, 'debtor_uuid');
        $this->invoice = ResponseHelper::getObject($data, 'invoice', Invoice::class, true);

        return $this;
    }
}
