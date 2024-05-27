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
use Billie\Sdk\Model\Request\AbstractRequestModel;
use Billie\Sdk\Model\Request\CheckoutSession\Confirm\Debtor;

/**
 * @method string        getSessionUuid()
 * @method $this          setSessionUuid(string $sessionUuid)
 * @method Amount        getAmount()
 * @method $this          setAmount(Amount $amount)
 * @method int           getDuration()
 * @method $this          setDuration(int $duration)
 * @method Debtor        getDebtor()
 * @method $this          setDebtor(Debtor $debtor)
 * @method Address|null  getDeliveryAddress()
 * @method $this          setDeliveryAddress(?Address $deliveryAddress)
 * @method string|null   getExternalCode()
 * @method $this          setExternalCode(?string $externalCode)
 */
class CheckoutSessionConfirmRequestModel extends AbstractRequestModel
{
    protected string $sessionUuid;

    protected Amount $amount;

    protected int $duration;

    protected Debtor $debtor;

    protected ?Address $deliveryAddress = null;

    protected ?string $externalCode = null;

    protected function prepareValuesForGateway(array $data): array
    {
        unset($data['sessionUuid']);

        return $data;
    }
}
