<?php

namespace Billie\Exception;

/**
 * Class OrderNotFoundException
 *
 * @package Billie\Exception
 * @author Marcel Barten <github@m-barten.de>
 */
class OrderNotFoundException extends BillieException
{
    protected $message = 'The order with the reference id: %s does not exist.';
    private $referenceId;

    /**
     * OrderNotFoundException constructor.
     *
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
        return 'ORDER_NOT_FOUND';
    }

    /**
     * @return string|void
     */
    public function getBillieMessage()
    {
        return sprintf($this->message, $this->referenceId);
    }
}