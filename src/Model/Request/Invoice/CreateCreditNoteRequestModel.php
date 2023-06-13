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
use Billie\Sdk\Model\Request\Invoice\CreateInvoice\LineItem;
use Billie\Sdk\Model\Request\InvoiceRequestModel;

/**
 * @method string getInvoiceNumber()
 * @method self setComment(string $comment)
 * @method string getComment()
 * @method self setAmount(Amount $amount)
 * @method Amount getAmount()
 * @method self setLineItems(LineItem[]|null $lineItems)
 * @method LineItem[]|null getLineItems()
 */
class CreateCreditNoteRequestModel extends InvoiceRequestModel
{
    protected string $invoiceNumber;

    protected Amount $amount;

    protected ?string $comment = null;

    /**
     * @var LineItem[]|null
     */
    protected ?array $lineItems = null;

    public function __construct(string $uuid, string $invoiceNumber)
    {
        parent::__construct($uuid);
        $this->invoiceNumber = $invoiceNumber;
    }

    public function addLineItems(LineItem $item): self
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

    protected function _toArray(): array
    {
        return [
            'external_code' => $this->invoiceNumber,
            'comment' => $this->comment,
            'amount' => $this->amount->toArray(),
            'line_items' => array_map(static fn (LineItem $item): array => $item->toArray(), $this->lineItems ?? []),
        ];
    }
}
