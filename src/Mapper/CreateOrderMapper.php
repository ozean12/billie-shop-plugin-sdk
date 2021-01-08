<?php

namespace Billie\Mapper;

use Billie\Command\CreateOrder;
use Billie\Model\Address;
use Billie\Model\BankAccount;
use Billie\Model\Company;
use Billie\Model\Order;
use Ramsey\Uuid\Uuid;

/**
 * Class CreateOrderMapper
 *
 * @package Billie\Mapper
 * @author Marcel Barten <github@m-barten.de>
 */
class CreateOrderMapper
{
    use OrderObjectFromArrayTrait;

    /**
     * @param CreateOrder $object
     * @return array
     */
    public static function arrayFromCreateOrderObject($object)
    {
        return [
            'debtor_person' => [
                'salutation' => $object->debtorPerson->salution,
                'first_name' => $object->debtorPerson->firstname,
                'last_name' => $object->debtorPerson->lastname,
                'phone_number' => $object->debtorPerson->phone,
                'email' => $object->debtorPerson->email
            ],
            'debtor_company' => [
                'merchant_customer_id' => $object->debtorCompany->customerId ?: $object->debtorPerson->email,
                'name' => $object->debtorCompany->name,
                'address_addition' => $object->debtorCompany->address->addition,
                'address_house_number' => $object->debtorCompany->address->houseNumber,
                'address_street' => $object->debtorCompany->address->street,
                'address_city' => $object->debtorCompany->address->city,
                'address_postal_code' => $object->debtorCompany->address->postalCode,
                'address_country' => $object->debtorCompany->address->countryCode,
                'tax_id' => $object->debtorCompany->taxId,
                'tax_number' => $object->debtorCompany->taxNumber,
                'registration_court' => $object->debtorCompany->registrationCourt,
                'registration_number' => $object->debtorCompany->registrationNumber,
                'industry_sector' => 'n/a',
                'subindustry_sector' => 'n/a',
                'employees_number' => $object->debtorCompany->countOfEmployees,
                'legal_form' => $object->debtorCompany->legalForm,
            ],
            'delivery_address' => [
                'addition' => $object->deliveryAddress->addition,
                'house_number' => $object->deliveryAddress->houseNumber,
                'street' => $object->deliveryAddress->street,
                'city' => $object->deliveryAddress->city,
                'postal_code' => $object->deliveryAddress->postalCode,
                'country' => $object->deliveryAddress->countryCode
            ],
            'amount' => [
                'net' => (double) ($object->amount->netAmount / 100),
                'gross' => (double) ($object->amount->grossAmount / 100),
                'tax' => (double) ($object->amount->taxAmount / 100)
            ],
            'duration' => $object->duration,
        ];
    }

}