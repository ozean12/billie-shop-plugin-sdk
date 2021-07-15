<?php

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
    /** @var string */
    protected $name;

    /** @var Address */
    protected $address;

    public function fromArray($data)
    {
        $this->name = ResponseHelper::getValue($data, 'name');
        $this->address = (new Address(ArrayHelper::removePrefixFromKeys($data, 'address_'), $this->readOnly));

        return $this;
    }

    public function toArray()
    {
        $addressData = ArrayHelper::addPrefixToKeys($this->getAddress()->toArray(), 'address_');

        return array_merge([
            'name' => $this->getName(),
        ], $addressData);
    }
}
