<?php

namespace Billie\Exception;

/**
 * Class InvalidRequestException
 *
 * @package Billie\Exception
 * @author Marcel Barten <github@m-barten.de>
 */
class InvalidRequestException extends BillieException
{

    private $serverMessage;

    /**
     * InvalidRequestException constructor.
     *
     * @param string $serverMessage
     */
    public function __construct($serverMessage)
    {
        parent::__construct();
        $this->serverMessage = $serverMessage;
    }
}