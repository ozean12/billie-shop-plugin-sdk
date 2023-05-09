<?php
/*
 * Copyright (c) Billie GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Billie\Sdk\Model\Request\Order;

use Billie\Sdk\Model\Amount;
use Billie\Sdk\Model\Request\OrderRequestModel;

/**
 * @method string|null getExternalCode()
 * @method self        setExternalCode(?string $externalCode)
 * @method Amount|null getAmount()
 * @method self        setAmount(?Amount $amount)
 */
class UpdateOrderRequestModel extends OrderRequestModel
{
    protected ?string $externalCode = null;

    protected ?Amount $amount = null;

    protected function _toArray(): array
    {
        return [
            'amount' => $this->getAmount() instanceof Amount ? $this->getAmount()->toArray() : null,
            'external_code' => $this->getExternalCode(),
        ];
    }
}
