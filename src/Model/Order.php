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
use DateTimeInterface;

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
    public const STATE_AUTHORIZED = 'authorized';

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

    protected ?string $externalCode;

    protected string $uuid;

    protected string $state;

    protected ?string $declineReason;

    protected Amount $amount;

    protected Amount $unshippedAmount;

    protected int $duration;

    protected Debtor $debtor;

    protected array $externalData = [];

    protected ?Address $deliveryAddress;

    protected DateTimeInterface $createdAt;

    protected ?string $selectedPaymentMethod; // may be null on declined orders

    /**
     * @var OrderPaymentMethod[]
     */
    protected array $paymentMethods = [];

    /**
     * @var Invoice[]
     */
    protected array $invoices = [];

    protected function prepareModelData(array $data): array
    {
        return [
            'paymentMethods' => ResponseHelper::getArray($data, 'payment_methods', OrderPaymentMethod::class),
            'invoices' => ResponseHelper::getArray($data, 'invoices', Invoice::class),
        ];
    }
}
