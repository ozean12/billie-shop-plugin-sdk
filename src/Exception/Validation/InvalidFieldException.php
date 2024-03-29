<?php
/*
 * Copyright (c) Billie GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Billie\Sdk\Exception\Validation;

use Billie\Sdk\Exception\BillieException;
use Billie\Sdk\Model\AbstractModel;

class InvalidFieldException extends BillieException
{
    public function __construct(string $fieldName, AbstractModel $object)
    {
        parent::__construct(
            sprintf('The field %s does not exist on object %s.', $fieldName, get_class($object)),
            'VALIDATION_ERROR'
        );
    }
}
