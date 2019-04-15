<?php

namespace Billie\Model;

/**
 * Class Order
 *
 * @package Billie\Model
 * @author Marcel Barten <github@m-barten.de>
 */
class Order
{
    const STATE_CREATED = 'created';
    const STATE_DECLINED = 'declined';
    const STATE_SHIPPED = 'shipped';
    const STATE_CANCELLED = 'canceled';

    /** @var string */
    public $id;
    /** @var string */
    public $externalOrderId;
    /** @var string */
    public $state;
    /** @var BankAccount */
    public $bankAccount;
    /** @var Company */
    public $debtorCompany;
    /** @var Invoice */
    public $invoice;
    /** @var string */
    public $reasons;
}