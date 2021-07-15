<?php

namespace Billie\Sdk\Exception;

/**
 * Class OrderNotCancelledException
 *
 * @author Marcel Barten <github@m-barten.de>
 */
class OrderNotCancelledException extends BillieException
{
    /**
     * @var string
     */
    protected $message = 'The order %s has not been cancelled.';

    /**
     * @var string
     */
    private $referenceId;

    /**
     * @param string $referenceId
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
