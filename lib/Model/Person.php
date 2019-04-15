<?php

namespace Billie\Model;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;

/**
 * Class Person
 *
 * @package Billie\Model
 * @author Marcel Barten <github@m-barten.de>
 */
class Person
{
    /**
     * @var string gender ('m' or 'f')
     */
    public $salution;
    public $firstname;
    public $lastname;
    /**
     * @var string telephone number (e.g. +49 30 1234567)
     */
    public $phone;

    /**
     * @var string email
     */
    public $email;

    /**
     * @param string $email
     */
    public function __construct($email)
    {
        $this->email = $email;
    }

    /**
     * @param ClassMetadata $metadata
     */
    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraints('salution', [
                new Assert\Choice(['m', 'f']),
                new Assert\NotBlank()
            ]
        );
        $metadata->addPropertyConstraints('email', [
                new Assert\NotBlank(),
                new Assert\Email()
            ]
        );
    }
}