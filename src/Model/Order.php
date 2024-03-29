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
 * @method string        getExternalCode()
 * @method string        getUuid()
 * @method string        getState()
 * @method string        getDeclineReason()
 * @method Amount        getAmount()
 * @method Amount        getUnshippedAmount()
 * @method int           getDuration()
 * @method Debtor getDebtor()
 * @method array         getExternalData()
 * @method Address       getDeliveryAddress()
 * @method DateTime      getCreatedAt()
 * @method Invoice[]     getInvoices()
 * @method string        getSelectedPaymentMethod()
 * @method OrderPaymentMethod[]        getPaymentMethods()
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

    /**
     * @var string
     */
    public const PAYMENT_METHOD_BANK_TRANSFER = 'bank_transfer';

    /**
     * @var string
     */
    public const PAYMENT_METHOD_DIRECT_DEBIT = 'bank_transfer';

    protected ?string $externalCode = null;

    protected string $uuid;

    protected string $state;

    protected ?string $declineReason = null;

    protected Amount $amount;

    protected Amount $unshippedAmount;

    protected int $duration;

    protected Debtor $debtor;

    protected ?Address $deliveryAddress = null;

    protected DateTime $createdAt;

    protected string $selectedPaymentMethod;

    /**
     * @var OrderPaymentMethod[]
     */
    protected array $paymentMethods = [];

    /**
     * @var Invoice[]
     */
    protected array $invoices = [];

    public function fromArray(array $data): self
    {
        $this->externalCode = ResponseHelper::getString($data, 'external_code');
        $this->uuid = ResponseHelper::getStringNN($data, 'uuid');
        $this->state = ResponseHelper::getStringNN($data, 'state');
        $this->declineReason = ResponseHelper::getString($data, 'decline_reason');
        $this->amount = ResponseHelper::getObjectNN($data, 'amount', Amount::class, true);
        $this->unshippedAmount = ResponseHelper::getObjectNN($data, 'unshipped_amount', Amount::class, true);
        $this->duration = ResponseHelper::getIntNN($data, 'duration');
        $this->debtor = ResponseHelper::getObjectNN($data, 'debtor', Debtor::class, true);
        $this->deliveryAddress = ResponseHelper::getObjectNN($data, 'delivery_address', Address::class, true);
        $this->createdAt = ResponseHelper::getDateTimeNN($data, 'created_at', 'Y-m-d H:i:s');
        $this->invoices = ResponseHelper::getArray($data, 'invoices', Invoice::class, true) ?? [];
        $this->selectedPaymentMethod = ResponseHelper::getString($data, 'selected_payment_method') ?? ''; // may be null on declined orders
        $this->paymentMethods = ResponseHelper::getArray($data, 'payment_methods', OrderPaymentMethod::class, true) ?? [];

        return $this;
    }
}
