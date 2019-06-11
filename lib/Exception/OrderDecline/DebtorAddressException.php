<?php

namespace Billie\Exception\OrderDecline;

/**
 * Class DebtorAddressException
 *
 * @package Billie\Exception\OrderDecline
 * @author Marcel Barten <github@m-barten.de>
 */
class DebtorAddressException extends OrderDeclinedException
{
    /**
     * DebtorAddressException constructor.
     */
    public function __construct()
    {
        parent::__construct('The order was declined, because the address seems to be wrong.');
    }

    /**
     * @return string
     */
    public function getBillieCode()
    {
        return 'DEBTOR_ADDRESS';
    }
}