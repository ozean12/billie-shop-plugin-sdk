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
    public $referenceId;
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
     * @var string
     */
    public $orderId;

    /**
     * ReduceOrderAmount constructor.
     *
     * @param string $referenceId
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
        $metadata->addPropertyConstraint('amount', new Assert\Valid());

        // invoice_url and invoice_number are checked in BillieClient, since there are only mandatory if status === SHIPPED
    }
}