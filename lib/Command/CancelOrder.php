<?php

namespace Billie\Command;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;

/**
 * Class CancelOrder
 *
 * @package Billie\Command
 * @author Marcel Barten <github@m-barten.de>
 */
class CancelOrder
{
    /**
     * @var string
     */
    public $referenceId;

    /**
     * CancelOrder constructor.
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
    }
}