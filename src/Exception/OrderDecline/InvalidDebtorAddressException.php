<?php

declare(strict_types=1);

namespace Billie\Sdk\Exception\OrderDecline;

use Billie\Sdk\Model\Order;
use Billie\Sdk\Model\Request\CreateOrderRequestModel;

class InvalidDebtorAddressException extends OrderDeclinedException
{
    public function __construct(CreateOrderRequestModel $requestModel, Order $declinedOrder)
    {
        parent::__construct(
            $requestModel,
            $declinedOrder,
            'The order was declined, because the address seems to be wrong.',
            'DEBTOR_ADDRESS'
        );
    }
}
