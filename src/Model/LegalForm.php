<?php
/*
 * Copyright (c) Billie GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Billie\Sdk\Model;

/**
 * @method int|null getCode()
 * @method string|null getName()
 * @method string|null getRequiredField()
 * @method bool isRequired()
 */
class LegalForm extends AbstractModel
{
    protected static array $_additionalFieldMapping = [
        'requiredField' => 'required_input',
    ];

    protected ?int $code;

    protected ?string $name;

    protected ?string $requiredField;

    protected bool $required = false;
}
