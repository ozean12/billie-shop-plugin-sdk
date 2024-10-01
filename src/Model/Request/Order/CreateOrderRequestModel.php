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
 * @method $this            setAmount(Amount $amount)
 * @method Amount          getAmount()
 * @method $this            setDuration(int $duration)
 * @method int             getDuration()
 * @method $this            setDebtor(Debtor $debtor)
 * @method Debtor          getDebtor()
 * @method $this            setPerson(Person $person)
 * @method Person          getPerson()
 * @method $this            setComment(?string $comment)
 * @method string|null     getComment()
 * @method $this            setExternalCode(?string $externalCode)
 * @method string|null     getExternalCode()
 * @method $this            setDeliveryAddress(?Address $deliveryAddress)
 * @method Address|null    getDeliveryAddress()
 * @method $this            setLineItems(LineItem[] $lineItems)
 * @method LineItem[]      getLineItems()
 */
class CreateOrderRequestModel extends AbstractRequestModel
{
    protected static array $_additionalFieldMapping = [
        'person' => 'debtor_person',
    ];

    protected Amount $amount;

    protected int $duration = 14;

    protected Debtor $debtor;

    protected Person $person;

    protected ?string $comment;

    protected ?string $externalCode;

    protected ?Address $deliveryAddress;

    /**
     * @var LineItem[]
     */
    protected array $lineItems = [];

    public function addLineItem(LineItem $lineItem): self
    {
        $this->lineItems[] = $lineItem;

        return $this;
    }

    protected function getFieldValidations(): array
    {
        return [
            'lineItems' => LineItem::class . '[]', // TODO add count-validation
        ];
    }
}
