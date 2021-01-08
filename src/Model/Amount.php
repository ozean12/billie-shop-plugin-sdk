<?php

namespace Billie\Model;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;

/**
 * Class Amount
 *
 * @package Billie/Model
 * @author Marcel Barten <github@m-barten.de>
 */
class Amount
{
    /**
     * @var int
     */
    public $netAmount;
    /**
     * @var int
     */
    public $grossAmount;
    /**
     * @var int
     */
    public $taxAmount;
    /**
     * @var string
     */
    public $currency = 'EUR';


    /**
     * @return bool
     */
    public function hasValidNumbers()
    {
        return $this->grossAmount === $this->taxAmount + $this->netAmount;
    }

    /**
     * Amount constructor.
     *
     * @param int $netAmount
     * @param int $currency
     * @param int $taxAmount
     */
    public function __construct($netAmount, $currency, $taxAmount)
    {
        $this->netAmount = $netAmount;
        $this->taxAmount = $taxAmount;
        $this->grossAmount = $netAmount + $taxAmount;
        $this->currency = $currency;
    }

    /**
     * @param ClassMetadata $metadata
     */
    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('netAmount', new Assert\GreaterThan(0));
        $metadata->addPropertyConstraint('grossAmount', new Assert\GreaterThan(0));
        $metadata->addPropertyConstraint('taxAmount', new Assert\GreaterThanOrEqual(0));

        $metadata->addPropertyConstraints('currency', [
            new Assert\NotBlank(),
            new Assert\Currency()
        ]);

        $metadata->addGetterConstraint('validNumbers', new Assert\IsTrue());
    }
}