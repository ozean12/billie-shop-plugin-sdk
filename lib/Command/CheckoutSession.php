<?php

namespace Billie\Command;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;

/**
 * Class CheckoutSession
 *
 * @package Billie\Command
 * @author Niels Gongoll
 */
class CheckoutSession
{
    /**
     * @var string
     */
    public $merchantCustomerId;

    /**
     * CheckoutSession constructor.
     *
     * @param string $merchantCustomerId
     */
    public function __construct($merchantCustomerId)
    {
        $this->merchantCustomerId = $merchantCustomerId;
    }

    /**
     * @param ClassMetadata $metadata
     */
    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraints('merchantCustomerId', [
            new Assert\NotBlank()
        ]);
    }
}
