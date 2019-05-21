<?php

namespace Billie\Model;

use Billie\Util\LegalFormProvider;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;

/**
 * Class Company
 *
 * @package Billie/Model
 * @author Marcel Barten <github@m-barten.de>
 */
class Company
{
    /**
     * @var string|null equals merchant customer ID
     */
    public $customerId;
    /**
     * @var string name of the company
     */
    public $name;
    /**
     * @var Address
     */
    public $address;
    /**
     * @var string VAT-ID (german: USt.-Id) - e.g. DE310295470 (optional)
     */
    public $taxId;
    /**
     * @var string tax number (german: Steuernummer) (optional)
     */
    public $taxNumber;
    /**
     * @var string court where the company has been registered - e.g. Amtsgericht Charlottenburg (optional)
     */
    public $registrationCourt;
    /**
     * @var string Handelsregisternummer (german) - e.g. HRB 182428 B (optional)
     */
    public $registrationNumber;
    /**
     * @var integer number of employees in the company (optional)
     */
    public $countOfEmployees;
    /**
     * @var string legal form of the company - e.g. UG, GmbH, GbR
     */
    public $legalForm;

    /**
     * Company constructor.
     *
     * @param string|null $customerId
     * @param string $name
     * @param Address $address
     */
    public function __construct($customerId, $name, $address)
    {
        $this->customerId = $customerId;
        $this->name = $name;
        $this->address = $address;
    }

    /**
     * @return bool
     */
    public function isValidLegalForm()
    {
        return !empty(LegalFormProvider::get($this->legalForm));
    }

    /**
     * @return bool
     */
    public function hasValidLegalFormInformation()
    {
        if (empty($this->taxId) && LegalFormProvider::isVatIdRequired($this->legalForm)) {
            return false;
        }

        if (empty($this->registrationNumber) && empty($this->registrationCourt) && LegalFormProvider::isRegistrationIdRequired($this->legalForm)) {
            return false;
        }

        return true;
    }

    /**
     * @param ClassMetadata $metadata
     */
    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('name', new Assert\NotBlank());
        $metadata->addPropertyConstraints('address', [
            new Assert\NotNull(),
            new Assert\Valid(['groups' => ['Default', 'company_address']])
        ]);
        $metadata->addPropertyConstraint('legalForm', new Assert\NotBlank());
        $metadata->addGetterConstraint('validLegalForm', new Assert\IsTrue());
        $metadata->addGetterConstraint('validLegalFormInformation', new Assert\IsTrue(['message' => 'Please provide required legal information.']));
    }
}