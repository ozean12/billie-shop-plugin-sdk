<?php

namespace Billie\Sdk\Model\Request;

use Billie\Sdk\Model\Address;
use Billie\Sdk\Model\Amount;
use Billie\Sdk\Model\DebtorCompany;

/**
 * @method string        getSessionUuid()
 * @method self          setSessionUuid(string $sessionUuid)
 * @method Amount        getAmount()
 * @method self          setAmount(Amount $amount)
 * @method int           getDuration()
 * @method self          setDuration(int $duration)
 * @method DebtorCompany getCompany()
 * @method self          setCompany(DebtorCompany $company)
 * @method Address       getDeliveryAddress()
 * @method self          setDeliveryAddress(Address $deliveryAddress)
 * @method string        getOrderId()
 * @method self          setOrderId(string $orderId)
 */
class CheckoutSessionConfirmRequestModel extends AbstractRequestModel
{
    /**
     * @var string
     */
    protected $sessionUuid;

    /**
     * @var Amount
     */
    protected $amount;

    /**
     * @var int
     */
    protected $duration;

    /**
     * @var DebtorCompany
     */
    protected $company;

    /**
     * @var Address
     */
    protected $deliveryAddress;

    /**
     * @var string
     */
    protected $orderId;

    public function getFieldValidations()
    {
        return [
            'sessionUuid' => 'string',
            'amount' => Amount::class,
            'duration' => 'integer',
            'company' => DebtorCompany::class,
            'deliveryAddress' => '?' . Address::class,
            'orderId' => '?string',
        ];
    }

    public function toArray()
    {
        return [
            'amount' => $this->getAmount()->toArray(),
            'duration' => $this->getDuration(),
            'debtor_company' => $this->getCompany()->toArray(),
            'delivery_address' => $this->deliveryAddress ? $this->deliveryAddress->toArray() : null,
            'order_id' => $this->getOrderId(),
        ];
    }
}
