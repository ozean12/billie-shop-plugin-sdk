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
 * @method $this setName(string $name)
 * @method bool isEstablishedCustomer()
 * @method $this setEstablishedCustomer(bool $establishedCustomer)
 * @method Address getAddress()
 * @method $this setAddress(Address $address)
 */
class DebtorCompany extends AbstractRequestModel
{
    protected string $name;

    protected Address $address;

    protected bool $establishedCustomer = false;

    protected static array $_additionalFieldMapping = [
        'address' => false,
    ];

    protected function prepareValuesForGateway(array $data): array
    {
        return array_merge(
            $data,
            ArrayHelper::addPrefixToKeys($this->address->toArray($this->_validateOnSet), 'address_')
        );
    }
}
