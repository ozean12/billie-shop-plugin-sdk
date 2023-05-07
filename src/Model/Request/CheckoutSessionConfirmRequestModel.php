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
use Billie\Sdk\Model\Debtor;
use Billie\Sdk\Util\ValidationConstants;

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
    protected ?string $sessionUuid = null;

    protected ?Amount $amount = null;

    protected ?int $duration = null;

    protected ?Debtor $debtor = null;

    protected ?Address $deliveryAddress = null;

    protected ?string $externalCode = null;

    public function getFieldValidations(): array
    {
        return [
            'sessionUuid' => ValidationConstants::TYPE_STRING_REQUIRED,
            'amount' => Amount::class,
            'duration' => ValidationConstants::TYPE_INT_REQUIRED,
            'debtor' => Debtor::class,
            'deliveryAddress' => '?' . Address::class,
            'externalCode' => ValidationConstants::TYPE_STRING_OPTIONAL,
        ];
    }

    public function toArray(): array
    {
        return [
            'amount' => $this->getAmount()->toArray(),
            'duration' => $this->getDuration(),
            'debtor' => $this->getDebtor()->toArray(),
            'delivery_address' => $this->deliveryAddress instanceof Address ? $this->deliveryAddress->toArray() : null,
            'external_code' => $this->getExternalCode(),
        ];
    }

    protected function getDeprecations(): array
    {
        return [
            'company' => 'debtor',
            'orderId' => 'externalCode',
        ];
    }
}
