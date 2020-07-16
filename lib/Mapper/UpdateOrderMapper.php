<?php

namespace Billie\Mapper;

use Billie\Command\UpdateOrder;

/**
 * Class UpdateOrderMapper
 *
 * @package Billie\Mapper
 * @author Marcel Barten <github@m-barten.de>
 */
class UpdateOrderMapper
{
    /**
     * @param $object
     * @return array
     */
    public static function arrayFromCommandObject($object)
    {
        $mapperObject = [];

        if(isset($object->orderId)){
            $mapperObject['order_id'] = $object->orderId;
        }
        if(isset($object->invoiceNumber)){
            $mapperObject['invoice_number'] = $object->invoiceNumber;
        }
        if(isset($object->invoiceUrl)){
            $mapperObject['invoice_url'] = $object->invoiceUrl;
        }
        if(isset($object->amount)){
            $mapperObject['amount'] = [
                'net' => (double) ($object->amount->netAmount / 100),
                'gross' => (double) ($object->amount->grossAmount / 100),
                'tax' => (double) ($object->amount->taxAmount / 100)
            ];
        }
        if(isset($object->duration)){
            $mapperObject['duration'] = $object->duration;
        }

        return $mapperObject;

    }
}