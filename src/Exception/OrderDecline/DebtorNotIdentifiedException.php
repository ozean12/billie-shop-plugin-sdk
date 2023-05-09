<?php
/*
 * Copyright (c) Billie GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Billie\Sdk\Exception\OrderDecline;

use Billie\Sdk\Model\Order;
use Billie\Sdk\Model\Request\Order\CreateOrderRequestModel;

class DebtorNotIdentifiedException extends OrderDeclinedException
{
    public function __construct(CreateOrderRequestModel $requestModel, Order $declinedOrder)
    {
        parent::__construct(
            $requestModel,
            $declinedOrder,
            'The order was declined, because there was no match with the given information.',
            'DEBTOR_NOT_IDENTIFIED'
        );
    }
}
