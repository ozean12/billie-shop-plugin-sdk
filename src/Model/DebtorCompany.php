<?php
/*
 * Copyright (c) Billie GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Billie\Sdk\Model;

use Billie\Sdk\Util\ArrayHelper;
use Billie\Sdk\Util\ResponseHelper;

/**
 * @method self    setName(string $name)
 * @method string  getName()
 * @method self    setAddress(Address $address)
 * @method Address getAddress()
 */
class DebtorCompany extends AbstractModel
{
    protected ?string $name = null;

    protected Address $address;

    public function fromArray(array $data): self
    {
        $this->name = ResponseHelper::getString($data, 'name');
        $this->address = (new Address(ArrayHelper::removePrefixFromKeys($data, 'address_'), $this->readOnly));

        return $this;
    }

    public function toArray(): array
    {
        $addressData = ArrayHelper::addPrefixToKeys($this->getAddress()->toArray(), 'address_');

        return array_merge([
            'name' => $this->getName(),
        ], $addressData);
    }
}
