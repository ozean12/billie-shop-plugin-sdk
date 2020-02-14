<?php

namespace Billie\Model;


use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;

/**
 * Class DebtorCompany
 *
 * @package Billie/Model
 * @author Marcel Barten <github@m-barten.de>
 */
class DebtorCompany
{

    /**
     * @var string name of the company
     */
    public $name;

    /**
     * @var string addressStreet
     */
    public $addressStreet;

    /**
     * @var string addressCity
     */
    public $addressCity;

    /**
     * @var string addressPostalCode
     */
    public $addressPostalCode;

    /**
     * @var string addressCountry
     */
    public $addressCountry;

    /**
     * @var string addressAddition
     */
    public $addressAddition;

    /**
     * @var string addressHouseNumber
     */
    public $addressHouseNumber;


    /**
     * @param ClassMetadata $metadata
     */
    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('addressStreet', new Assert\NotBlank());
        $metadata->addPropertyConstraint('addressCity', new Assert\NotBlank());
        $metadata->addPropertyConstraint('addressPostalCode', new Assert\NotBlank());
        $metadata->addPropertyConstraint('addressPostalCode', new Assert\Length(
            [
                'min' => 5,
                'max' => 5
            ]
        ));
        $metadata->addPropertyConstraint('addressCountry', new Assert\NotBlank());
        $metadata->addPropertyConstraint('addressCountry', new Assert\Country());
    }
}