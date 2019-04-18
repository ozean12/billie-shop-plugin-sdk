<?php

namespace Billie\Mapper;

use Billie\Command\PostponeOrderDueDate;
use Billie\Command\ReduceOrderAmount;

/**
 * Class UpdateOrderMapper
 *
 * @package Billie\Mapper
 * @author Marcel Barten <github@m-barten.de>
 */
class UpdateOrderMapper
{
    /**
     * @param ReduceOrderAmount|PostponeOrderDueDate $object
     * @return array
     */
    public static function arrayFromCommandObject($object)
    {
        if ($object instanceof ReduceOrderAmount) {
            return [
                'invoice_number' => $object->invoiceNumber,
                'invoice_url' => $object->invoiceUrl,
                'amount' => [
                    'net' => (double) ($object->amount->netAmount / 100),
                    'gross' => (double) ($object->amount->grossAmount / 100),
                    'tax' => (double) ($object->amount->taxAmount / 100)
                ],
            ];
        }

        if ($object instanceof PostponeOrderDueDate) {
            return [
                'duration' => $object->duration
            ];
        }

        return [];
    }
}