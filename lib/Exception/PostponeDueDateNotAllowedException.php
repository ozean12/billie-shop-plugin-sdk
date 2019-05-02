<?php

namespace Billie\Exception;

/**
 * Class PostponeDueDateNotAllowedException
 *
 * @package Billie\Exception
 * @author Marcel Barten <github@m-barten.de>
 */
class PostponeDueDateNotAllowedException extends BillieException
{
    protected $message = 'The duration of %s can only be updated, if the order is shipped and the current due date is in the future.';
    private $referenceId;

    /**
     * PostponeDueDateNotAllowedException constructor.
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
        return 'POSTPONE_DUE_DATE_NOT_ALLOWED';
    }

    /**
     * @return string
     */
    public function getBillieMessage()
    {
        return sprintf($this->message, $this->referenceId);
    }
}