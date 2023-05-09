<?php

declare(strict_types=1);

namespace Billie\Sdk\Exception\OrderDecline;

use Billie\Sdk\Model\Order;
use Billie\Sdk\Model\Request\CreateOrderRequestModel;

class RiskPolicyDeclinedException extends OrderDeclinedException
{
    public function __construct(CreateOrderRequestModel $requestModel, Order $declinedOrder)
    {
        parent::__construct(
            $requestModel,
            $declinedOrder,
            'The order was declined by Billie due to its risk policy.',
            'RISK_POLICY'
        );
    }
}
