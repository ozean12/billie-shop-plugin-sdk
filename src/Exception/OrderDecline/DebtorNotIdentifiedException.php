<?php

declare(strict_types=1);

namespace Billie\Sdk\Exception\OrderDecline;

use Billie\Sdk\Model\Order;
use Billie\Sdk\Model\Request\CreateOrderRequestModel;

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
