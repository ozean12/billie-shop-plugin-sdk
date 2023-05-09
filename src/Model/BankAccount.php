<?php
/*
 * Copyright (c) Billie GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Billie\Sdk\Model;

use Billie\Sdk\Model\Response\AbstractResponseModel;
use Billie\Sdk\Util\ResponseHelper;

/**
 * @method self   setIban(string $iban)
 * @method string getIban()
 * @method self   setBic(string $bic)
 * @method string getBic()
 */
class BankAccount extends AbstractResponseModel
{
    protected ?string $iban = null;

    protected ?string $bic = null;

    public function fromArray(array $data): self
    {
        $this->iban = ResponseHelper::getString($data, 'iban');
        $this->bic = ResponseHelper::getString($data, 'bic');

        return $this;
    }

    public function toArray(): array
    {
        return [
            'iban' => $this->iban,
            'bic' => $this->bic,
        ];
    }

    public function getFieldValidations(): array
    {
        return [
            'iban' => 'string',
            'bic' => 'string',
        ];
    }
}
