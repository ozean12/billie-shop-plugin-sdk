<?php

namespace Billie\Exception\OrderDecline;

/**
 * Class DebtorNotIdentifiedException
 *
 * @package Billie\Exception\OrderDecline
 * @author Marcel Barten <github@m-barten.de>
 */
class DebtorNotIdentifiedException extends OrderDeclinedException
{
    /**
     * DebtorNotIdentifiedException constructor.
     */
    public function __construct()
    {
        parent::__construct('The order was declined, because there was no match with the given information.');
    }

    /**
     * @return string
     */
    public function getBillieCode()
    {
        return 'DEBTOR_NOT_IDENTIFIED';
    }
}