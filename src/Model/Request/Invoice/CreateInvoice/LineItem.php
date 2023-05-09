<?php
/*
 * Copyright (c) Billie GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Billie\Sdk\Model\Request\Invoice\CreateInvoice;

use Billie\Sdk\Model\Request\AbstractRequestModel;

/**
 * @method self setExternalId(string $externalId)
 * @method string getExternalId()
 * @method self setQuantity(int $quantity)
 * @method int getQuantity()
 */
class LineItem extends AbstractRequestModel
{
    protected string $externalId;

    protected int $quantity;

    public function __construct(string $externalId, int $quantity)
    {
        parent::__construct();

        $this->externalId = $externalId;
        $this->quantity = $quantity;
    }

    protected function _toArray(): array
    {
        return [
            'external_id' => $this->externalId,
            'quantity' => $this->quantity,
        ];
    }
}
