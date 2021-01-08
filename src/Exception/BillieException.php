<?php

namespace Billie\Sdk\Exception;

/**
 * Class BillieException
 *
 * @package Billie\Exception
 * @author Marcel Barten <github@m-barten.de>
 */
class BillieException extends \Exception
{
    /**
     * @return string
     * @deprecated
     */
    public function getBillieMessage() {
        return $this->message ? : 'Unknown Error';
    }

    /**
     * @return string
     */
    public function getBillieCode() {
        return '000';
    }
}