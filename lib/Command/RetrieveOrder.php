<?php

namespace Billie\Command;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;

/**
 * Class RetrieveOrder
 *
 * @package Billie\Command
 * @author Marcel Barten <github@m-barten.de>
 */
class RetrieveOrder
{
    /**
     * @var string
     */
    public $id;

    /**
     * RetrieveOrder constructor.
     *
     * @param string $orderId
     */
    public function __construct($orderId)
    {
        $this->id = $orderId;
    }

    /**
     * @param ClassMetadata $metadata
     */
    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraints('id', [
            new Assert\Uuid(),
            new Assert\NotBlank()
        ]);
    }
}