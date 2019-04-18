<?php

namespace Billie\Exception;

/**
 * Class OrderNotShippedException
 *
 * @package Billie\Exception
 * @author Marcel Barten <github@m-barten.de>
 */
class OrderNotShippedException extends BillieException
{
    private $orderId;
    private $reason;

    /**
     * OrderDeclinedException constructor.
     *
     * @param string $reason
     */
    public function __construct($orderId, $reason)
    {
        parent::__construct();
        $this->orderId = $orderId;
        $this->reason = $reason;
    }

    /**
     * @return string
     */
    public function getBillieMessage()
    {
        return sprintf('The shipment of the order %s has been declined! (reason: %s)', $this->orderId, $this->reason);
    }
}