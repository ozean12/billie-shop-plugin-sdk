<?php
/*
 * Copyright (c) Billie GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Billie\Sdk\Model\Request\CheckoutSession\Confirm;

use Billie\Sdk\Model\Address;
use Billie\Sdk\Model\Request\AbstractRequestModel;

/**
 * @method string getName()
 * @method self setName(string $name)
 */
class Debtor extends AbstractRequestModel
{
    protected string $name;

    protected Address $companyAddress;

    public function getAddress(): Address
    {
        return $this->companyAddress;
    }

    public function setAddress(Address $address): self
    {
        $this->companyAddress = $address;

        return $this;
    }

    protected function _toArray(): array
    {
        return [
            'name' => $this->name,
            'company_address' => $this->companyAddress->toArray(),
        ];
    }
}
