<?php

namespace Billie\Exception\OrderDecline;

use Billie\Exception\BillieException;

/**
 * Class OrderDeclinedException
 *
 * @package Billie\Exception
 * @author Marcel Barten <github@m-barten.de>
 */
class OrderDeclinedException extends BillieException
{
    protected $message;

    /**
     * OrderDeclinedException constructor.
     *
     * @param $message
     */
    public function __construct($message)
    {
        parent::__construct();
        $this->message = $message;
    }

    /**
     * @return string
     */
    public function getBillieCode()
    {
        return 'ORDER_DECLINED';
    }

    /**
     * @return string
     */
    public function getBillieMessage()
    {
        return sprintf('%s', $this->message);
    }

}