<?php

namespace Billie\Exception\OrderDecline;

/**
 * Class DebtorLimitExceededException
 *
 * @package Billie\Exception\OrderDecline
 * @author Marcel Barten <github@m-barten.de>
 */
class DebtorLimitExceededException extends OrderDeclinedException
{
    /**
     * DebtorLimitExceededException constructor.
     */
    public function __construct()
    {
        parent::__construct('The order was declined because the maximum due amount for the debtor has been reached.');
    }

    /**
     * @return string
     */
    public function getBillieCode()
    {
        return 'DEBTOR_LIMIT_EXCEEDED';
    }
}