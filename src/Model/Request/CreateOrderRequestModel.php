<?php

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
    /** @var Amount */
    protected $amount;

    /** @var int */
    protected $duration = 14;

    /** @var Company */
    protected $company;

    /** @var Person */
    protected $person;

    /** @var string */
    protected $comment;

    /** @var string */
    protected $orderId;

    /** @var Address */
    protected $deliveryAddress;

    /** @var Address */
    protected $billingAddress;

    /** @var LineItem[] */
    protected $lineItems = [];

    public function addLineItem(LineItem $lineItem)
    {
        $this->lineItems[] = $lineItem;

        return $this;
    }

    public function toArray()
    {
        return [
            'amount' => $this->amount ? $this->amount->toArray() : null,
            'duration' => $this->duration,
            'debtor_company' => $this->company->toArray(),
            'debtor_person' => $this->person->toArray(),
            'comment' => $this->comment,
            'order_id' => $this->orderId,
            'delivery_address' => $this->deliveryAddress->toArray(),
            'billing_address' => $this->billingAddress->toArray(),
            'line_items' => array_map(static function (LineItem $item) {
                return $item->toArray();
            }, $this->lineItems),
        ];
    }

    public function getFieldValidations()
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
