<?php

namespace Billie\Mapper;

use Billie\Command\CheckoutSessionConfirm;

/**
 * Class CheckoutSessionConfirmMapper
 *
 * @package Billie\Mapper
 * @author Marcel Barten <github@m-barten.de>
 */
class CheckoutSessionConfirmMapper
{
    use OrderObjectFromArrayTrait;

    /**
     * @param $object
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
            ],
            'debtor_company' => [
                'name' => $object->debtorCompany->name,
                'address_street' => $object->debtorCompany->addressStreet,
                'address_city' => $object->debtorCompany->addressCity,
                'address_postal_code' => $object->debtorCompany->addressPostalCode,
                'address_country' => $object->debtorCompany->addressCountry,
                'address_addition' => $object->debtorCompany->addressAddition,
                'address_house_number' => $object->debtorCompany->addressHouseNumber
            ]
        ];
    }

}