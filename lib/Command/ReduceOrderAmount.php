<?php

namespace Billie\Command;

use Billie\Model\Amount;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;

/**
 * Class UpdateOrderAmount
 *
 * @package Billie\Command
 * @author Marcel Barten <github@m-barten.de>
 */
class ReduceOrderAmount
{
    /**
     * @var string
     */
    public $id;
    /**
     * @var string
     */
    public $invoiceNumber;
    /**
     * @var string
     */
    public $invoiceUrl;
    /**
     * @var Amount
     */
    public $amount;


    /**
     * @param ClassMetadata $metadata
     */
    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraints('id', [
            new Assert\Uuid(),
            new Assert\NotBlank()
        ]);
        $metadata->addPropertyConstraint('invoiceUrl', new Assert\Url());
        $metadata->addPropertyConstraint('amount', new Assert\Valid());
    }
}