<?php

namespace Billie\Mapper;

use Billie\Command\CreateOrder;
use Billie\Command\ShipOrder;
use Billie\Model\Address;
use Billie\Model\BankAccount;
use Billie\Model\Company;
use Billie\Model\Order;

/**
 * Class OrderMapper
 *
 * @package Billie\Mapper
 * @author Marcel Barten <github@m-barten.de>
 */
class ShipOrderMapper
{
    use OrderObjectFromArrayTrait;

    /**
     * @param ShipOrder $object
     * @return array
     */
    public static function arrayFromCommandObject($object)
    {
        return [
            'external_order_id' => $object->orderId,
            'invoice_number' => $object->invoiceNumber,
            'invoice_url' => $object->invoiceUrl,
            'shipping_document_url' => $object->shippingDocumentUrl,
        ];
    }

}