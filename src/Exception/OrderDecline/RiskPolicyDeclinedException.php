<?php

namespace Billie\Exception\OrderDecline;

/**
 * Class RiskPolicyDeclinedException
 *
 * @package Billie\Exception\OrderDecline
 * @author Marcel Barten <github@m-barten.de>
 */
class RiskPolicyDeclinedException extends OrderDeclinedException
{
    /**
     * RiskPolicyDeclinedException constructor.
     */
    public function __construct()
    {
        parent::__construct('The order was declined by Billie due to its risk policy.');
    }

    /**
     * @return string
     */
    public function getBillieCode()
    {
        return 'RISK_POLICY';
    }
}