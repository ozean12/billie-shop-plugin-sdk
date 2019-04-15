<?php

namespace Billie\Mapper;

use Billie\Command\CreateOrder;
use Billie\Model\Address;
use Billie\Model\BankAccount;
use Billie\Model\Company;
use Billie\Model\Order;

/**
 * Class OrderMapper
 *
 * @package Billie\Mapper
 */
class OrderMapper
{
    /**
     * @param array $orderResponse
     * @return Order
     */
    public static function objectFromArray($orderResponse)
    {
        $object = new Order();
        $object->id = $orderResponse['uuid'];
        $object->externalOrderId = '';
        $object->state = $orderResponse['state'];

        $object->invoice = null;

        $object->bankAccount = new BankAccount($orderResponse['bank_account']['iban'], $orderResponse['bank_account']['bic']);

        $companyAddress = new Address();
        $companyAddress->street = $orderResponse['debtor_company']['address_street'];
        $companyAddress->houseNumber = $orderResponse['debtor_company']['address_house_number'];
        $companyAddress->city = $orderResponse['debtor_company']['address_city'];
        $companyAddress->postalCode = $orderResponse['debtor_company']['address_postal_code'];
        $companyAddress->countryCode = $orderResponse['debtor_company']['address_country'];
        $object->debtorCompany = new Company('', $orderResponse['debtor_company']['name'], $companyAddress);

        return $object;
    }


    /**
     * @param CreateOrder $object
     * @return array
     */
    public static function arrayFromCreateOrderObject($object)
    {
        return [
            'order_id' => (string) time(), // TODO: remove
            'debtor_person' => [
                'salutation' => $object->debtorPerson->salution,
                'first_name' => $object->debtorPerson->firstname,
                'last_name' => $object->debtorPerson->lastname,
                'phone_number' => $object->debtorPerson->phone,
                'email' => $object->debtorPerson->email
            ],
            'debtor_company' => [
                'merchant_customer_id' => $object->debtorCompany->customerId,
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
                'industry_sector' => $object->debtorCompany->industrySector,
                'subindustry_sector' => $object->debtorCompany->subIndustrySector,
                'employees_number' => $object->debtorCompany->countOfEmployees,
                'legal_form' => $object->debtorCompany->legalForm,
                'established_customer' => $object->debtorCompany->establishedCustomer
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