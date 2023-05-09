<?php

declare(strict_types=1);

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
 * @method Address|null  getDeliveryAddress()
 * @method self          setDeliveryAddress(?Address $deliveryAddress)
 * @method string|null   getOrderId()
 * @method self          setOrderId(?string $orderId)
 */
class CheckoutSessionConfirmRequestModel extends AbstractRequestModel
{
    protected ?string $sessionUuid = null;

    protected ?Amount $amount = null;

    protected ?int $duration = null;

    protected ?DebtorCompany $company = null;

    protected ?Address $deliveryAddress = null;

    protected ?string $orderId = null;

    public function getFieldValidations(): array
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

    public function toArray(): array
    {
        return [
            'amount' => $this->getAmount()->toArray(),
            'duration' => $this->getDuration(),
            'debtor_company' => $this->getCompany()->toArray(),
            'delivery_address' => $this->deliveryAddress instanceof Address ? $this->deliveryAddress->toArray() : null,
            'order_id' => $this->getOrderId(),
        ];
    }
}
