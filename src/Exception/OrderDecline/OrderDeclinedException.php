<?php

namespace Billie\Sdk\Exception\OrderDecline;

use Billie\Sdk\Exception\BillieException;
use Billie\Sdk\Model\Order;
use Billie\Sdk\Model\Request\CreateOrderRequestModel;

class OrderDeclinedException extends BillieException
{
    /**
     * @var CreateOrderRequestModel
     */
    private $requestModel;

    /**
     * @var Order
     */
    private $declinedOrder;

    public function __construct(
        CreateOrderRequestModel $requestModel,
        Order $declinedOrder,
        $message,
        $code = 'ORDER_DECLINED'
    ) {
        parent::__construct($message, $code);
        $this->requestModel = $requestModel;
        $this->declinedOrder = $declinedOrder;
    }

    /**
     * @return CreateOrderRequestModel
     */
    public function getRequestModel()
    {
        return $this->requestModel;
    }

    /**
     * @return Order
     */
    public function getDeclinedOrder()
    {
        return $this->declinedOrder;
    }
}
