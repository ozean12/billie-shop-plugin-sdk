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
    private $referenceId;
    private $reason;

    /**
     * OrderDeclinedException constructor.
     *
     * @param string $referenceId
     * @param string $reason
     */
    public function __construct($referenceId, $reason)
    {
        parent::__construct();
        $this->referenceId = $referenceId;
        $this->reason = $reason;
    }

    /**
     * @return string
     */
    public function getReason()
    {
        return $this->reason;
    }

    /**
     * @return string
     */
    public function getBillieCode()
    {
        return 'ORDER_NOT_SHIPPED';
    }

    /**
     * @return string
     */
    public function getBillieMessage()
    {
        return sprintf('The shipment of the order %s has been declined! (reason: %s)', $this->referenceId, $this->reason);
    }
}