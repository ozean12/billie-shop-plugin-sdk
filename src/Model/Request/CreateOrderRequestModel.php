<?php
/*
 * Copyright (c) Billie GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Billie\Sdk\Model\Request;

use Billie\Sdk\Model\Address;
use Billie\Sdk\Model\Amount;
use Billie\Sdk\Model\LineItem;
use Billie\Sdk\Model\Person;
use Billie\Sdk\Model\Request\CreateOrder\Debtor;
use Billie\Sdk\Util\ValidationConstants;

/**
 * @method self            setAmount(Amount $amount)
 * @method Amount          getAmount()
 * @method self            setDuration(int $duration)
 * @method int             getDuration()
 * @method self            setDebtor(Debtor $debtor)
 * @method Debtor          getDebtor()
 * @method self            setPerson(Person $person)
 * @method Person          getPerson()
 * @method self            setComment(?string $comment)
 * @method string|null     getComment()
 * @method self            setExternalCode(?string $externalCode)
 * @method string|null     getExternalCode()
 * @method self            setDeliveryAddress(?Address $deliveryAddress)
 * @method Address|null    getDeliveryAddress()
 * @method self            setLineItems(?LineItem[] $lineItems)
 * @method LineItem[]|null getLineItems()
 */
class CreateOrderRequestModel extends AbstractRequestModel
{
    protected ?Amount $amount = null;

    protected ?int $duration = 14;

    protected ?Debtor $debtor = null;

    protected ?Person $person = null;

    protected ?string $comment = null;

    protected ?string $externalCode = null;

    protected ?Address $deliveryAddress = null;

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
            'debtor' => $this->debtor instanceof Debtor ? $this->debtor->toArray() : null,
            'debtor_person' => $this->person instanceof Person ? $this->person->toArray() : null,
            'comment' => $this->comment,
            'external_code' => $this->externalCode,
            'delivery_address' => $this->deliveryAddress instanceof Address ? $this->deliveryAddress->toArray() : null,
            'line_items' => array_map(static fn (LineItem $item): array => $item->toArray(), $this->lineItems ?? []),
        ];
    }

    public function getFieldValidations(): array
    {
        return [
            'amount' => Amount::class,
            'duration' => ValidationConstants::TYPE_INT_REQUIRED,
            'debtor' => Debtor::class,
            'person' => Person::class,
            'comment' => ValidationConstants::TYPE_STRING_OPTIONAL,
            'externalCode' => ValidationConstants::TYPE_STRING_OPTIONAL,
            'deliveryAddress' => '?' . Address::class,
            'lineItems' => ValidationConstants::TYPE_ARRAY_REQUIRED, // TODO add type-validation & min-count
        ];
    }
}
