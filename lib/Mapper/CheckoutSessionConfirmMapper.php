<?php

namespace Billie\Mapper;

use Billie\Command\CheckoutSessionConfirm;

/**
 * Class OrderMapper
 *
 * @package Billie\Mapper
 * @author Marcel Barten <github@m-barten.de>
 */
class CheckoutSessionConfirmMapper
{
    use OrderObjectFromArrayTrait;

    /**
     * @param ShipOrder $object
     * @return array
     */
    public static function arrayFromCommandObject($object)
    {
        return [
            'duration' => $object->duration,
            'amount' => [
                'net' => (double) ($object->amount->netAmount / 100),
                'gross' => (double) ($object->amount->grossAmount / 100),
                'tax' => (double) ($object->amount->taxAmount / 100)
            ]
        ];
    }

}