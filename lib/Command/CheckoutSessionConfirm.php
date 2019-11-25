<?php

namespace Billie\Command;

use Billie\Model\Amount;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;

/**
 * Class CheckoutSessionConfirm
 *
 * @package Billie\Command
 * @author Niels Gongoll
 */
class CheckoutSessionConfirm
{
    /**
     * @var string
     */
    public $uuid;
    /**
     * @var integer
     */
    public $duration;
    /**
     * @var Amount
     */
    public $amount;

    /**
     * CheckoutSessionConfirm constructor.
     *
     * @param string $Uuid
     */
    public function __construct($uuid)
    {
        $this->uuid = $uuid;
    }

    /**
     * @param ClassMetadata $metadata
     */
    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraints('uuid', [
            new Assert\NotBlank(),
            new Assert\Uuid()
        ]);
        $metadata->addPropertyConstraints('duration',[
            new Assert\Range([
                'min' => 1,
                'max' => 120
        ])]);
        $metadata->addPropertyConstraint('amount', new Assert\Valid());
    }
}