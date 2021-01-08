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
    public $referenceId;
    /**
     * @var string
     */
    public $orderId;
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
     * ShipOrder constructor.
     *
     * @param $referenceId
     */
    public function __construct($referenceId)
    {
        $this->referenceId = $referenceId;
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
    }
}