<?php

namespace Billie\Command;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;

/**
 * Class ShipOrder
 *
 * @package Billie\Command
 * @author Marcel Barten <github@m-barten.de>
 */
class ShipOrder
{
    /**
     * @var string
     */
    public $id;
    /**
     * @var string
     */
    public $externalOrderId;
    /**
     * @var string
     */
    public $invoiceNumber;
    /**
     * @var string
     */
    public $invoiceUrl;
    /**
     * @var string|null
     */
    public $shippingDocumentUrl;


    /**
     * @param ClassMetadata $metadata
     */
    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraints('id', [
            new Assert\Uuid(),
            new Assert\NotBlank()
        ]);
        $metadata->addPropertyConstraint('externalOrderId', new Assert\NotBlank());
        $metadata->addPropertyConstraint('invoiceNumber', new Assert\NotBlank());
        $metadata->addPropertyConstraints('invoiceUrl', [
            new Assert\Url(),
            new Assert\NotBlank()
        ]);
        $metadata->addPropertyConstraints('shippingDocumentUrl', [
            new Assert\Url(),
        ]);
    }
}