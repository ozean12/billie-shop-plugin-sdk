<?php

declare(strict_types=1);

namespace Billie\Sdk\Exception\Validation;

use Billie\Sdk\Exception\BillieException;
use Billie\Sdk\Model\AbstractModel;

class InvalidFieldException extends BillieException
{
    /**
     * InvalidFieldException constructor.
     *
     * @param string                          $fieldName
     * @param AbstractModel $object
     */
    public function __construct($fieldName, $object)
    {
        parent::__construct(
            sprintf('The field %s does not exist on object %s.', $fieldName, get_class($object)),
            'VALIDATION_ERROR'
        );
    }
}
