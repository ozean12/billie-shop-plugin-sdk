<?php

namespace Billie\Command;

use Billie\Model\Address;
use Billie\Model\Amount;
use Billie\Model\Company;
use Billie\Model\Person;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;

/**
 * Class CreateOrder
 *
 * @package Billie\Command
 * @author Marcel Barten <github@m-barten.de>
 */
class CreateOrder
{
    /**
     * @var Person
     */
    public $debtorPerson;
    /**
     * @var Company
     */
    public $debtorCompany;
    /**
     * @var Address
     */
    public $deliveryAddress;
    /**
     * @var Amount
     */
    public $amount;
    /**
     * @var int
     *
     * Number of days, the debtor has to pay the invoice (e.g. 14)
     */
    public $duration = 14;


    /**
     * @param ClassMetadata $metadata
     */
    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('debtorPerson', new Assert\Valid());
        $metadata->addPropertyConstraint('debtorCompany', new Assert\Valid());
        $metadata->addPropertyConstraint('deliveryAddress', new Assert\Valid());
        $metadata->addPropertyConstraint('amount', new Assert\Valid());
        $metadata->addPropertyConstraint('duration', new Assert\NotBlank());
    }
}