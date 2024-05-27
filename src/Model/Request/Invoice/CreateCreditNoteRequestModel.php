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
use Billie\Sdk\Model\Request\InvoiceRequestModel;

/**
 * @method string getExternalNumber()
 * @method $this setComment(string $comment)
 * @method string getComment()
 * @method $this setAmount(Amount $amount)
 * @method Amount getAmount()
 * @method $this setLineItems(LineItem[]|null $lineItems)
 * @method LineItem[]|null getLineItems()
 */
class CreateCreditNoteRequestModel extends InvoiceRequestModel
{
    protected static array $_additionalFieldMapping = [
        'externalNumber' => 'external_code',
    ];

    protected string $externalNumber;

    protected Amount $amount;

    protected ?string $comment = null;

    /**
     * @var LineItem[]|null
     */
    protected ?array $lineItems = null;

    public function __construct(string $uuid, string $externalNumber)
    {
        parent::__construct($uuid);
        $this->externalNumber = $externalNumber;
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
            'lineItems' => '?' . LineItem::class . '[]',
        ];
    }

    protected function prepareValuesForGateway(array $data): array
    {
        return array_merge(parent::prepareValuesForGateway($data), [
            'line_items' => array_map(static fn (LineItem $item): array => $item->toArray(), $this->lineItems ?? []),
        ]);
    }
}
