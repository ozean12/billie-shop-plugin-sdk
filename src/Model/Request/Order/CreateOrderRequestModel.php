<?php
/*
 * Copyright (c) Billie GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Billie\Sdk\Model\Request\Order;

use Billie\Sdk\Model\Address;
use Billie\Sdk\Model\Amount;
use Billie\Sdk\Model\LineItem;
use Billie\Sdk\Model\Person;
use Billie\Sdk\Model\Request\AbstractRequestModel;
use Billie\Sdk\Model\Request\Order\CreateOrder\Debtor;

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
 * @method self            setLineItems(LineItem[] $lineItems)
 * @method LineItem[]      getLineItems()
 */
class CreateOrderRequestModel extends AbstractRequestModel
{
    protected Amount $amount;

    protected int $duration = 14;

    protected Debtor $debtor;

    protected Person $person;

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

    protected function _toArray(): array
    {
        return [
            'amount' => $this->amount->toArray(),
            'duration' => $this->duration,
            'debtor' => $this->debtor->toArray(),
            'debtor_person' => $this->person->toArray(),
            'comment' => $this->comment,
            'external_code' => $this->externalCode,
            'delivery_address' => $this->deliveryAddress instanceof Address ? $this->deliveryAddress->toArray() : null,
            'line_items' => array_map(static fn (LineItem $item): array => $item->toArray(), $this->lineItems ?? []),
        ];
    }

    protected function getFieldValidations(): array
    {
        return [
            'lineItems' => LineItem::class . '[]', // TODO add count-validation
        ];
    }
}
