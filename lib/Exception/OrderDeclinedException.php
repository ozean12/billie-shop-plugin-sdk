<?php

namespace Billie\Exception;

/**
 * Class OrderDeclinedException
 *
 * @package Billie\Exception
 * @author Marcel Barten <github@m-barten.de>
 */
class OrderDeclinedException extends BillieException
{
    private $billieReason;

    /**
     * OrderDeclinedException constructor.
     *
     * @param string $billieReason
     */
    public function __construct($billieReason)
    {
        parent::__construct();
        $this->billieReason = $billieReason;
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
    public function getBillieReason()
    {
        return strtoupper($this->billieReason);
    }

    /**
     * @return string
     */
    private function getReasonMessage()
    {
        switch ($this->getBillieReason()) {
            case 'DEBTOR_ADDRESS':
                return 'The order was declined, because the address seems to be wrong.';
                break;

            case 'DEBTOR_NOT_IDENTIFIED':
                return 'The order was declined, because there was no match with the given information.';
                break;

            case 'RISK_POLICY':
                return 'The order was declined by Billie due to its risk policy.';
                break;

            case 'DEBTOR_LIMIT_EXCEEDED':
                return 'The order was declined because the maximum due amount for the debtor has been reached.';
                break;
            default:
                return 'The order was declined.';
        }
    }

    /**
     * @return string
     */
    public function getBillieMessage()
    {
        return sprintf('%s', $this->getReasonMessage());
    }

}