<?php
/*
 * Copyright (c) Billie GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Billie\Sdk\Model\Request\Widget;

use Billie\Sdk\Model\Address;
use Billie\Sdk\Model\Request\AbstractRequestModel;
use Billie\Sdk\Util\ArrayHelper;

/**
 * @method string getName()
 * @method self setName(string $name)
 * @method bool isEstablishedCustomer()
 * @method self setEstablishedCustomer(bool $establishedCustomer)
 * @method Address getAddress()
 * @method self setAddress(Address $address)
 */
class DebtorCompany extends AbstractRequestModel
{
    protected string $name;

    protected Address $address;

    protected bool $establishedCustomer = false;

    protected function _toArray(): array
    {
        return array_merge(
            [
                'name' => $this->name,
                'established_customer' => $this->establishedCustomer,
            ],
            ArrayHelper::addPrefixToKeys($this->address->toArray(), 'address_')
        );
    }
}
