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
    private $orderId;

    /**
     * OrderNotFoundException constructor.
     *
     * @param string $orderId
     */
    public function __construct($orderId)
    {
        parent::__construct();

        $this->orderId = $orderId;
    }
}