<?php
/*
 * Copyright (c) Billie GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Billie\Sdk\Model\Request\Invoice;

use Billie\Sdk\Model\Amount;
use Billie\Sdk\Model\Request\AbstractRequestModel;
use Billie\Sdk\Model\ShippingInformation;
use Billie\Sdk\Util\Validation;

/**
 * @method self setOrders(string[] $orderIds)
 * @method string[] getOrders()
 * @method self setInvoiceNumber(string $invoiceNumber)
 * @method string getInvoiceNumber()
 * @method self setInvoiceUrl(string $invoiceUrl)
 * @method string getInvoiceUrl()
 * @method self setShippingInformation(ShippingInformation $shippingInformation)
 * @method ShippingInformation getShippingInformation()
 * @method self setAmount(Amount $amount)
 * @method Amount getAmount()
 * @method self setLineItems(LineItem[]|null $lineItems)
 * @method LineItem[]|null getLineItems()
 */
class CreateInvoiceRequestModel extends AbstractRequestModel
{
    protected static array $_additionalFieldMapping = [
        'invoiceNumber' => 'external_code',
        'shippingInformation' => 'shipping_info',
    ];

    /**
     * @var string[]
     */
    protected array $orders = [];

    protected string $invoiceNumber;

    protected string $invoiceUrl;

    protected ShippingInformation $shippingInformation;

    protected Amount $amount;

    /**
     * @var LineItem[]|null
     */
    protected ?array $lineItems = null;

    public function __construct()
    {
        parent::__construct();
        $this->shippingInformation = new ShippingInformation(); // can be an empty object, but is required
    }

    public function setOrderUuId(string $orderUuid): self
    {
        $this->orders = [$orderUuid];

        return $this;
    }

    public function setOrderExternalCode(string $orderExternalCode): self
    {
        $this->orders = [$orderExternalCode];

        return $this;
    }

    public function addLineItem(LineItem $item): self
    {
        $items = $this->getLineItems() ?? [];
        $items[] = $item;
        $this->setLineItems($items);

        return $this;
    }

    protected function getFieldValidations(): array
    {
        return [
            'orders' => Validation::TYPE_STRING_REQUIRED . '[]',
            'lineItems' => '?' . LineItem::class . '[]',
        ];
    }

    protected function prepareValuesForGateway(array $data): array
    {
        return array_merge($data, [
            'line_items' => array_map(static fn (LineItem $item): array => $item->toArray(), $this->lineItems ?? []),
        ]);
    }
}
