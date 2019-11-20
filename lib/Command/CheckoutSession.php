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
     * RetrieveOrder constructor.
     *
     * @param string $merchantCustomerId
     */
    public function __construct($merchant_customer_id)
    {
        $this->merchantCustomerId = $merchant_customer_id;
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