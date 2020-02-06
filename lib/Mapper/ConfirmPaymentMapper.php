<?php

namespace Billie\Mapper;

use Billie\Command\ConfirmPayment;

/**
 * Class ConfirmPaymentMapper
 *
 * @package Billie\Mapper
 * @author Marcel Barten <github@m-barten.de>
 */
class ConfirmPaymentMapper
{
    /**
     * @param ConfirmPayment $object
     * @return array
     */
    public static function arrayFromCommandObject($object)
    {
        return [
            'paid_amount' => $object->paidAmount / 100
        ];
    }
}