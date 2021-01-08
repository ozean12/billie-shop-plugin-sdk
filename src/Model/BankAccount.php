<?php

namespace Billie\Model;

/**
 * Class BankAccount
 *
 * @package Billie/Model
 * @author Marcel Barten <github@m-barten.de>
 */
class BankAccount
{
    /**
     * @var string IBAN number of the virtual account
     */
    public $iban;
    /**
     * @var string BIC of the virtual account
     */
    public $bic;

    /**
     * BankAccount constructor.
     *
     * @param string $iban
     * @param string $bic
     */
    public function __construct($iban, $bic)
    {
        $this->iban = $iban;
        $this->bic = $bic;
    }
}