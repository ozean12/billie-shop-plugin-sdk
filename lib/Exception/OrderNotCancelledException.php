<?php

namespace Billie\Exception;

/**
 * Class OrderNotCancelledException
 *
 * @package Billie\Exception
 * @author Marcel Barten <github@m-barten.de>
 */
class OrderNotCancelledException extends BillieException
{
    protected $message = 'The order %s has not been cancelled.';
    private $referenceId;

    /**
     * OrderNotCancelledException constructor.
     *
     * @param $referenceId
     */
    public function __construct($referenceId)
    {
        parent::__construct();
        $this->referenceId = $referenceId;
    }

    /**
     * @return string
     */
    public function getBillieCode()
    {
        return 'ORDER_NOT_CANCELLED';
    }

    /**
     * @return string
     */
    public function getBillieMessage()
    {
        return sprintf($this->message, $this->referenceId);
    }
}