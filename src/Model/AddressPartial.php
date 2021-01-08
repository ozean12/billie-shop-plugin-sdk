<?php

namespace Billie\Model;

class AddressPartial
{
    public $street;
    public $houseNumber;

    public function __construct($street, $houseNumber)
    {
        $this->street = $street;
        $this->houseNumber = $houseNumber;
    }
}
