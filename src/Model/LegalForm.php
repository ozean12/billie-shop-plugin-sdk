<?php
/*
 * Copyright (c) Billie GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Billie\Sdk\Model;

use Billie\Sdk\Util\ResponseHelper;

class LegalForm extends AbstractModel
{
    private ?int $code = null;

    private ?string $name = null;

    private ?string  $requiredField = null;

    private bool $required = false;

    public function fromArray(array $data): self
    {
        $this->code = ResponseHelper::getInt($data, 'code');
        $this->name = ResponseHelper::getString($data, 'name');
        $this->requiredField = ResponseHelper::getString($data, 'required_input');
        $this->required = (bool) ResponseHelper::getBoolean($data, 'required');

        return $this;
    }

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
