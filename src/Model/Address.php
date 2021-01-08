<?php

namespace Billie\Model;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;

/**
 * Class Address
 *
 * @package Billie/Model
 * @author Marcel Barten <github@m-barten.de>
 */
class Address
{
    /**
     * @var string name of the street - e.g. Friedrichstrasse
     */
    public $street;
    /**
     * @var string house number - e.g. 14b
     */
    public $houseNumber;
    /**
     * @var string street name and house number combined (replaces street and houseNumber)
     */
    public $fullAddress;
    /**
     * @var string
     *
     * additional address information
     * @example c/o MYCOMPANY
     */
    public $addition;
    /**
     * @var string
     *
     * Name of the city
     */
    public $city;
    /**
     * @var string
     *
     * the postal code
     * @example 10999
     */
    public $postalCode;
    /**
     * @var string two-letter country code according to ISO-3166-1
     *
     * @link https://en.wikipedia.org/wiki/ISO_3166-1#Current_codes
     */
    public $countryCode;


    /**
     * @param ClassMetadata $metadata
     */
    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('street', new Assert\NotBlank());
        $metadata->addPropertyConstraint('houseNumber', new Assert\NotBlank(['groups' => ['company_address']]));
        $metadata->addPropertyConstraint('city', new Assert\NotBlank());
        $metadata->addPropertyConstraint('postalCode', new Assert\NotBlank());
        $metadata->addPropertyConstraint('postalCode', new Assert\Length(
            [
                'min' => 5,
                'max' => 5
            ]
        ));
        $metadata->addPropertyConstraint('countryCode', new Assert\NotBlank());
        $metadata->addPropertyConstraint('countryCode', new Assert\Country());
    }
}
