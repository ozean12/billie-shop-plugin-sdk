<?php

namespace Billie\Sdk\Model\Request\CreateOrder;

use Billie\Sdk\Exception\Validation\InvalidFieldValueException;
use Billie\Sdk\Model\Address;
use Billie\Sdk\Model\Request\AbstractRequestModel;
use Billie\Sdk\Util\LegalFormProvider;

/**
 * @method self    setMerchantCustomerId(string $merchantCustomerId)
 * @method self    getMerchantCustomerId()
 * @method self    setName(string $name)
 * @method string  getName()
 * @method self    setAddress(Address $address)
 * @method Address getAddress()
 * @method self    setTaxId(string $taxId)
 * @method string  getTaxId()
 * @method self    setTaxNumber(string $taxNumber)
 * @method string  getTaxNumber()
 * @method self    setRegistrationCourt(string $registrationCourt)
 * @method string  getRegistrationCourt()
 * @method self    setRegistrationNumber(string $registrationNumber)
 * @method string  getRegistrationNumber()
 * @method self    setIndustrySector(string $industrySector)
 * @method string  getIndustrySector()
 * @method self    setSubIndustrySector(string $subIndustrySector)
 * @method string  getSubIndustrySector()
 * @method self    setCountOfEmployees(int $countOfEmployees)
 * @method int     getCountOfEmployees()
 * @method self    setEstablishedCustomer(string $establishedCustomer)
 * @method string  getEstablishedCustomer()
 * @method self    setLegalForm(string $subIndustrySector)
 * @method string  getLegalForm()
 */
class Company extends AbstractRequestModel
{
    /**
     * @var string
     */
    protected $merchantCustomerId;

    /**
     * @var string name of the company
     */
    protected $name;

    /**
     * @var Address
     */
    protected $address;

    /**
     * @var string VAT-ID (german: USt.-Id) - e.g. DE310295470 (optional)
     */
    protected $taxId;

    /**
     * @var string tax number (german: Steuernummer) (optional)
     */
    protected $taxNumber;

    /**
     * @var string court where the company has been registered - e.g. Amtsgericht Charlottenburg (optional)
     */
    protected $registrationCourt;

    /**
     * @var string Handelsregisternummer (german) - e.g. HRB 182428 B (optional)
     */
    protected $registrationNumber;

    /** @var string */
    protected $industrySector;

    /** @var string */
    protected $subIndustrySector;

    /**
     * @var int number of employees in the company (optional)
     */
    protected $countOfEmployees;

    /** @var bool */
    protected $establishedCustomer;

    /**
     * @var string legal form of the company - e.g. UG, GmbH, GbR
     */
    protected $legalForm;

    public function toArray()
    {
        return [
            'merchant_customer_id' => $this->merchantCustomerId,
            'name' => $this->name,
            'legal_form' => $this->legalForm,
            'address_street' => $this->address->getStreet(),
            'address_city' => $this->address->getCity(),
            'address_postal_code' => $this->address->getPostalCode(),
            'address_country' => $this->address->getCountryCode(),
            'address_addition' => $this->address->getAddition(),
            'address_house_number' => $this->address->getHouseNumber(),
            'tax_id' => $this->taxId,
            'tax_number' => $this->taxNumber,
            'registration_court' => $this->registrationCourt,
            'registration_number' => $this->registrationNumber,
            'industry_sector' => $this->industrySector,
            'subindustry_sector' => $this->subIndustrySector,
            'employees_number' => $this->countOfEmployees,
            'established_customer' => $this->establishedCustomer,
        ];
    }

    public function getFieldValidations()
    {
        return [
            'merchantCustomerId' => 'string',
            'name' => 'string',
            'address' => Address::class,
            'taxId' => '?string',
            'taxNumber' => '?string',
            'registrationCourt' => '?string',
            'registrationNumber' => '?string',
            'industrySector' => '?string',
            'subIndustrySector' => '?string',
            'countOfEmployees' => '?string',
            'establishedCustomer' => '?string',
            'legalForm' => '?integer',
        ];
    }
}
