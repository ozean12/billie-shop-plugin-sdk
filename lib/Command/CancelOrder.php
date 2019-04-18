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
    public $id;


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