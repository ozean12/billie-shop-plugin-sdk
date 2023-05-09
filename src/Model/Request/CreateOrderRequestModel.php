<?php

declare(strict_types=1);

namespace Billie\Sdk\Model\Request;

use Billie\Sdk\Model\Address;
use Billie\Sdk\Model\Amount;
use Billie\Sdk\Model\LineItem;
use Billie\Sdk\Model\Person;
use Billie\Sdk\Model\Request\CreateOrder\Company;

/**
 * @method self            setAmount(Amount $amount)
 * @method Amount          getAmount()
 * @method self            setDuration(int $duration)
 * @method int             getDuration()
 * @method self            setCompany(Company $company)
 * @method Company         getCompany()
 * @method self            setPerson(Person $person)
 * @method Person          getPerson()
 * @method self            setComment(?string $comment)
 * @method string|null     getComment()
 * @method self            setOrderId(?string $orderId)
 * @method string|null     getOrderId()
 * @method self            setDeliveryAddress(?Address $deliveryAddress)
 * @method Address|null    getDeliveryAddress()
 * @method self            setBillingAddress(?Address $billingAddress)
 * @method Address|null    getBillingAddress()
 * @method self            setLineItems(?LineItem[] $lineItems)
 * @method LineItem[]|null getLineItems()
 */
class CreateOrderRequestModel extends AbstractRequestModel
{
    protected ?Amount $amount = null;

    protected ?int $duration = 14;

    protected ?Company $company = null;

    protected ?Person $person = null;

    protected ?string $comment = null;

    protected ?string $orderId = null;

    protected ?Address $deliveryAddress = null;

    protected ?Address $billingAddress = null;

    /**
     * @var LineItem[]
     */
    protected array $lineItems = [];

    public function addLineItem(LineItem $lineItem): self
    {
        $this->lineItems[] = $lineItem;

        return $this;
    }

    public function toArray(): array
    {
        return [
            'amount' => $this->amount instanceof Amount ? $this->amount->toArray() : null,
            'duration' => $this->duration,
            'debtor_company' => $this->company instanceof Company ? $this->company->toArray() : null,
            'debtor_person' => $this->person instanceof Person ? $this->person->toArray() : null,
            'comment' => $this->comment,
            'order_id' => $this->orderId,
            'delivery_address' => $this->deliveryAddress instanceof Address ? $this->deliveryAddress->toArray() : null,
            'billing_address' => $this->billingAddress instanceof Address ? $this->billingAddress->toArray() : null,
            'line_items' => array_map(static fn (LineItem $item): array => $item->toArray(), $this->lineItems ?? []),
        ];
    }

    public function getFieldValidations(): array
    {
        return [
            'amount' => Amount::class,
            'duration' => 'integer',
            'company' => Company::class,
            'person' => Person::class,
            'comment' => '?string',
            'orderId' => '?string',
            'deliveryAddress' => '?' . Address::class,
            'billingAddress' => '?' . Address::class,
            'lineItems' => '?array',
        ];
    }
}
