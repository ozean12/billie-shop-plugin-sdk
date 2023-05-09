<?php
/*
 * Copyright (c) Billie GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Billie\Sdk\Model\Request\CheckoutSession;

use Billie\Sdk\Model\Address;
use Billie\Sdk\Model\Amount;
use Billie\Sdk\Model\Debtor;
use Billie\Sdk\Model\Request\AbstractRequestModel;

/**
 * @method string        getSessionUuid()
 * @method self          setSessionUuid(string $sessionUuid)
 * @method Amount        getAmount()
 * @method self          setAmount(Amount $amount)
 * @method int           getDuration()
 * @method self          setDuration(int $duration)
 * @method Debtor        getDebtor()
 * @method self          setDebtor(Debtor $debtor)
 * @method Address|null  getDeliveryAddress()
 * @method self          setDeliveryAddress(?Address $deliveryAddress)
 * @method string|null   getExternalCode()
 * @method self          setExternalCode(?string $externalCode)
 */
class CheckoutSessionConfirmRequestModel extends AbstractRequestModel
{
    protected string $sessionUuid;

    protected Amount $amount;

    protected int $duration;

    protected Debtor $debtor;

    protected ?Address $deliveryAddress = null;

    protected ?string $externalCode = null;

    protected function _toArray(): array
    {
        return [
            'amount' => $this->amount->toArray(),
            'duration' => $this->getDuration(),
            'debtor' => $this->debtor->toArray(),
            'delivery_address' => $this->deliveryAddress instanceof Address ? $this->deliveryAddress->toArray() : null,
            'external_code' => $this->getExternalCode(),
        ];
    }
}
