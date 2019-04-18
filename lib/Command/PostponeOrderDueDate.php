<?php

namespace Billie\Command;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;

/**
 * Class PostponeOrderDueDate
 *
 * @package Billie\Command
 * @author Marcel Barten <github@m-barten.de>
 */
class PostponeOrderDueDate
{
    /**
     * @var string
     */
    public $id;
    /**
     * @var int
     */
    public $duration;


    /**
     * @param ClassMetadata $metadata
     */
    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraints('id', [
            new Assert\Uuid(),
            new Assert\NotBlank()
        ]);
        $metadata->addPropertyConstraint('duration', new Assert\Type('integer'));
    }
}