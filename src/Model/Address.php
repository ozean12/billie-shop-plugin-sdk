<?php

namespace Billie\Sdk\Model;

use Billie\Sdk\Exception\Validation\InvalidFieldValueException;
use Billie\Sdk\Util\ResponseHelper;

/**
 * @method string getStreet()
 * @method self setStreet(string $street)
 * @method null|string getHouseNumber()
 * @method self setHouseNumber(?string $houseNumber)
 * @method null|string getAddition()
 * @method self setAddition(?string $addition)
 * @method string getCity()
 * @method self setCity(string $city)
 * @method string getPostalCode()
 * @method self setPostalCode(string $postalCode)
 * @method string getCountryCode()
 * @method self setCountryCode(string $countryCode)
 */
class Address extends AbstractModel
{
    /** @var string */
    protected $street;

    /** @var string */
    protected $houseNumber;

    /** @var string */
    protected $addition;

    /** @var string */
    protected $city;

    /** @var string */
    protected $postalCode;

    /** @var string */
    protected $countryCode;

    public function fromArray($data)
    {
        $this->street = ResponseHelper::getValue($data, 'street');
        $this->houseNumber = ResponseHelper::getValue($data, 'house_number');
        $this->addition = ResponseHelper::getValue($data, 'addition');
        $this->city = ResponseHelper::getValue($data, 'city');
        $this->postalCode = ResponseHelper::getValue($data, 'postal_code');
        $this->countryCode = ResponseHelper::getValue($data, 'country');
        return $this;
    }

    public function toArray()
    {
        return [
            'street' => $this->street,
            'house_number' => $this->houseNumber,
            'addition' => $this->addition,
            'city' => $this->city,
            'postal_code' => $this->postalCode,
            'country' => $this->countryCode
        ];
    }

    public function getFieldValidations()
    {
        return [
            'street' => 'string',
            'houseNumber' => '?string',
            'addition' => '?string',
            'city' => 'string',
            'postalCode' => static function (self $object, $value) {
                if (is_numeric($value) === false || strlen($value) !== 5) {
                    throw new InvalidFieldValueException('The field `postalCode` must be 5 chars long. (german postcode format)');
                }
                return 'integer';
            },
            'countryCode' => static function (self $object, $value) {
                if (strlen($value) !== 2) {
                    throw new InvalidFieldValueException('The field `countryCode` must be 2 chars long. (ISO-3166-1)');
                }
                return 'string';
            },
        ];
    }
}
