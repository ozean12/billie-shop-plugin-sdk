<?php
/*
 * Copyright (c) Billie GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Billie\Sdk\Model\Request\Order\CreateOrder;

use Billie\Sdk\Model\Address;
use Billie\Sdk\Model\Request\AbstractRequestModel;

/**
 * @method $this        setMerchantCustomerId(string $merchantCustomerId)
 * @method $this        getMerchantCustomerId()
 * @method $this        setName(string $name)
 * @method string      getName()
 * @method $this        setCompanyAddress(Address $companyAddress)
 * @method Address     getCompanyAddress()
 * @method $this        setBillingAddress(Address $billingAddress)
 * @method Address|null getBillingAddress()
 * @method $this        setTaxId(?string $taxId)
 * @method string|null getTaxId()
 * @method $this        setTaxNumber(?string $taxNumber)
 * @method string|null getTaxNumber()
 * @method $this        setRegistrationCourt(?string $registrationCourt)
 * @method string|null getRegistrationCourt()
 * @method $this        setRegistrationNumber(?string $registrationNumber)
 * @method string|null getRegistrationNumber()
 * @method $this        setIndustrySector(?string $industrySector)
 * @method string|null getIndustrySector()
 * @method $this        setSubIndustrySector(?string $subIndustrySector)
 * @method string|null getSubIndustrySector()
 * @method $this        setCountOfEmployees(?string $countOfEmployees)
 * @method string|null    getCountOfEmployees()
 * @method $this        setEstablishedCustomer(?string $establishedCustomer)
 * @method string|null getEstablishedCustomer()
 * @method $this        setLegalForm(string $legalForm)
 * @method string      getLegalForm()
 */
class Debtor extends AbstractRequestModel
{
    protected static array $_additionalFieldMapping = [
        'subIndustrySector' => 'subindustry_sector',
        'countOfEmployees' => 'employees_number',
    ];

    protected string $merchantCustomerId;

    /**
     * @var string name of the company
     */
    protected string $name;

    protected Address $companyAddress;

    protected ?Address $billingAddress = null;

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
     * @var string|null number of employees in the company (optional)
     */
    protected ?string $countOfEmployees = null;

    protected bool $establishedCustomer = false;

    /**
     * @var string legal form of the company - e.g. UG, GmbH, GbR
     */
    protected string $legalForm;
}
