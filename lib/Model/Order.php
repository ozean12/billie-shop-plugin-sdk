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
    const STATE_COMPLETED = 'complete';
    const STATE_LATE = 'late';
    const STATE_PAID_OUT = 'paid_out';
    const STATE_CANCELLED = 'canceled';
    const STATE_PREAPPROVED = 'pre_approved';

    /** @var string */
    public $referenceId;
    /** @var string */
    public $orderId;
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
    /** @var float */
    public $amount;
    /** @var float */
    public $amountTax;
    /** @var float */
    public $amountNet;
}