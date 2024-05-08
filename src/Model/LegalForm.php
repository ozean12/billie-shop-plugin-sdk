<?php
/*
 * Copyright (c) Billie GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Billie\Sdk\Model;

class LegalForm extends AbstractModel
{
    protected static array $_additionalFieldMapping = [
        'requiredField' => 'required_input',
    ];

    protected ?int $code = null;

    protected ?string $name = null;

    protected ?string  $requiredField = null;

    protected bool $required = false;

    public function getCode(): ?int
    {
        return $this->code;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getRequiredField(): ?string
    {
        return $this->requiredField;
    }

    public function isRequired(): bool
    {
        return $this->required;
    }
}
