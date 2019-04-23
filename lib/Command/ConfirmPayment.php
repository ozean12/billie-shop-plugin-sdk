<?php

namespace Billie\Command;

use Billie\Model\Amount;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;

/**
 * Class ConfirmPayment
 *
 * @package Billie\Command
 * @author Marcel Barten <github@m-barten.de>
 */
class ConfirmPayment
{
    /**
     * @var string
     */
    public $referenceId;
    /**
     * @var integer
     */
    public $paidAmount;

    /**
     * ConfirmPayment constructor.
     *
     * @param string $referenceId
     * @param integer $paidAmount
     */
    public function __construct($referenceId, $paidAmount)
    {
        $this->referenceId = $referenceId;
        $this->paidAmount = $paidAmount;
    }

    /**
     * @param ClassMetadata $metadata
     */
    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraints('referenceId', [
            new Assert\Uuid(),
            new Assert\NotBlank()
        ]);
        $metadata->addPropertyConstraints('paidAmount', [
            new Assert\GreaterThan(0),
            new Assert\NotBlank()
        ]);
    }
}