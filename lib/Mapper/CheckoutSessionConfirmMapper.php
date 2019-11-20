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
            'amount' => $object->amount
        ];
    }

}