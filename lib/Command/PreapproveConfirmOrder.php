<?php

namespace Billie\Command;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;

/**
 * Class PreapproveConfirmOrder
 *
 * @package Billie\Command
 * @author Marcel Barten <github@m-barten.de>
 */
class PreapproveConfirmOrder
{
    /**
     * @var string
     *
     */
    public $id;

    public function __construct($id)
    {
        $this->id = $id;
    }
    /**
     * @param ClassMetadata $metadata
     */
    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('id', new Assert\NotBlank());
    }
}