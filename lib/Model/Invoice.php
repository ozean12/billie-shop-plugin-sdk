<?php

namespace Billie\Model;

/**
 * Class Invoice
 *
 * @package Billie\Model
 * @author Marcel Barten <github@m-barten.de>
 */
class Invoice
{
    public $number;
    public $url;
    public $payoutAmount;
    public $feeAmount;
    public $feeRate;
    public $dueDate;
}