<?php

namespace Billie\Exception;

/**
 * Class OrderDeclinedException
 *
 * @package Billie\Exception
 * @author Marcel Barten <github@m-barten.de>
 */
class OrderDeclinedException extends \Exception
{
    private $reason;

    /**
     * OrderDeclinedException constructor.
     *
     * @param string $reason
     */
    public function __construct($reason)
    {
        parent::__construct();
        $this->reason = $reason;
    }

    /**
     * @return string
     */
    public function getBillieCode()
    {
        return 'OC200';
    }

    /**
     * @return string
     */
    public function getBillieMessage()
    {
        return sprintf('The order has been declined! (reason: %s)', $this->reason);
    }

}