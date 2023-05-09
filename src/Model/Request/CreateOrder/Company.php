<?php
/*
 * Copyright (c) Billie GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Billie\Sdk\Model\Request\CreateOrder;

use Billie\Sdk\Model\Address;
use Billie\Sdk\Model\Request\AbstractRequestModel;

/**
 * @method self        setMerchantCustomerId(string $merchantCustomerId)
 * @method self        getMerchantCustomerId()
 * @method self        setName(string $name)
 * @method string      getName()
 * @method self        setAddress(Address $address)
 * @method Address     getAddress()
 * @method self        setTaxId(?string $taxId)
 * @method string|null getTaxId()
 * @method self        setTaxNumber(?string $taxNumber)
 * @method string|null getTaxNumber()
 * @method self        setRegistrationCourt(?string $registrationCourt)
 * @method string|null getRegistrationCourt()
 * @method self        setRegistrationNumber(?string $registrationNumber)
 * @method string|null getRegistrationNumber()
 * @method self        setIndustrySector(?string $industrySector)
 * @method string|null getIndustrySector()
 * @method self        setSubIndustrySector(?string $subIndustrySector)
 * @method string|null getSubIndustrySector()
 * @method self        setCountOfEmployees(?int $countOfEmployees)
 * @method int|null    getCountOfEmployees()
 * @method self        setEstablishedCustomer(?string $establishedCustomer)
 * @method string|null getEstablishedCustomer()
 * @method self        setLegalForm(?string $subIndustrySector)
 * @method string|null getLegalForm()
 */
class Company extends AbstractRequestModel
{
    protected ?string $merchantCustomerId = null;

    /**
     * @var string|null name of the company
     */
    protected ?string $name = null;

    protected ?Address $address = null;

    /**
     * @var string|null VAT-ID (german: USt.-Id) - e.g. DE310295470 (optional)
     */
    protected ?string $taxId = null;

    /**
     * @var string|null tax number (german: Steuernummer) (optional)
     */
    protected ?string $taxNumber = null;

    /**
     * @var string|null court where the company has been registered - e.g. Amtsgericht Charlottenburg (optional)
     */
    protected ?string $registrationCourt = null;

    /**
     * @var string|null Handelsregisternummer (german) - e.g. HRB 182428 B (optional)
     */
    protected ?string $registrationNumber = null;

    protected ?string $industrySector = null;

    protected ?string $subIndustrySector = null;

    /**
     * @var int|null number of employees in the company (optional)
     */
    protected ?int $countOfEmployees = null;

    protected bool $establishedCustomer = false;

    /**
     * @var string|null legal form of the company - e.g. UG, GmbH, GbR
     */
    protected ?string $legalForm = null;

    public function toArray(): array
    {
        return [
            'merchant_customer_id' => $this->merchantCustomerId,
            'name' => $this->name,
            'legal_form' => $this->legalForm,
            'address_street' => $this->address instanceof Address ? $this->address->getStreet() : null,
            'address_city' => $this->address instanceof Address ? $this->address->getCity() : null,
            'address_postal_code' => $this->address instanceof Address ? $this->address->getPostalCode() : null,
            'address_country' => $this->address instanceof Address ? $this->address->getCountryCode() : null,
            'address_addition' => $this->address instanceof Address ? $this->address->getAddition() : null,
            'address_house_number' => $this->address instanceof Address ? $this->address->getHouseNumber() : null,
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

    public function getFieldValidations(): array
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
            'establishedCustomer' => '?boolean',
            'legalForm' => '?string',
        ];
    }
}
