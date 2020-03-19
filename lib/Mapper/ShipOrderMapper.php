<?php

namespace Billie\Mapper;

use Billie\Command\CreateOrder;
use Billie\Command\ShipOrder;
use Billie\Model\Address;
use Billie\Model\BankAccount;
use Billie\Model\Company;
use Billie\Model\Order;

/**
 * Class ShipOrderMapper
 *
 * @package Billie\Mapper
 * @author Marcel Barten <github@m-barten.de>
 */

class ShipOrderMapper
{
    use OrderObjectFromArrayTrait;


    /**
     * @param $object
     * @param $submitExternalOrderId
     * @return array
     */
    public static function arrayFromCommandObject($object, $submitExternalOrderId)
    {
        return [
            'external_order_id' => ($submitExternalOrderId?$object->orderId:''),
            'invoice_number' => $object->invoiceNumber,
            'invoice_url' => $object->invoiceUrl,
            'shipping_document_url' => $object->shippingDocumentUrl,
        ];
    }

}