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
use Billie\Sdk\Model\AddressWithAddition;
use Billie\Sdk\Model\Amount;
use Billie\Sdk\Model\LineItem;
use Billie\Sdk\Model\Person;
use Billie\Sdk\Model\Request\AbstractRequestModel;
use Billie\Sdk\Model\Request\CheckoutSession\HostedPaymentPage\DebtorCompany;
use Billie\Sdk\Model\Request\CheckoutSession\HostedPaymentPage\MerchantUrls;
use Billie\Sdk\Util\ResponseHelper;

/**
 * @method $this setChannel(string $channel)
 * @method string getChannel()
 * @method $this setAmount(Amount $amount)
 * @method Amount getAmount()
 * @method $this setComment(string|null $comment)
 * @method string|null getComment()
 * @method $this setDuration(int $duration)
 * @method int getDuration()
 * @method $this setOrderId(string|null $orderId)
 * @method string|null getOrderId()
 * @method $this setDeliveryAddress(Address|null $deliveryAddress)
 * @method Address|null getDeliveryAddress()
 * @method $this setBillingAddress(Address|null $billingAddress)
 * @method Address|null getBillingAddress()
 * @method $this setDebtorCompany(DebtorCompany $debtorCompany)
 * @method DebtorCompany getDebtorCompany()
 * @method $this setDebtorPerson(Person $debtorPerson)
 * @method Person getDebtorPerson()
 * @method $this setLineItems(LineItem[] $lineItems)
 * @method LineItem[] getLineItems()
 * @method $this setMerchantUrls(MerchantUrls|null $merchantUrls)
 * @method MerchantUrls|null getMerchantUrls()
 */
class CreateHostedPaymentPageSessionRequestModel extends AbstractRequestModel
{
    protected string $channel;

    protected Amount $amount;

    protected ?string $comment = null;

    protected int $duration;

    protected ?string $orderId = null;

    protected ?AddressWithAddition $deliveryAddress = null;

    protected ?AddressWithAddition $billingAddress = null;

    protected DebtorCompany $debtorCompany;

    protected Person $debtorPerson;

    protected array $lineItems;

    protected ?MerchantUrls $merchantUrls = null;

    public function addLineItem(LineItem $lineItem): self
    {
        $this->lineItems ??= [];
        $this->lineItems[] = $lineItem;

        return $this;
    }

    protected function prepareModelData(array $data): array
    {
        return [
            'lineItems' => ResponseHelper::getArray($data, 'lineItems', LineItem::class),
        ];
    }

    protected function getFieldValidations(): array
    {
        return [
            'lineItems' => LineItem::class . '[]', // TODO add count-validation
        ];
    }
}
