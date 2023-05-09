<?php
/*
 * Copyright (c) Billie GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Billie\Sdk\Model;

use Billie\Sdk\Exception\Validation\InvalidFieldValueException;
use Billie\Sdk\Util\ResponseHelper;

/**
 * @method string      getStreet()
 * @method self        setStreet(string $street)
 * @method string|null getHouseNumber()
 * @method self        setHouseNumber(?string $houseNumber)
 * @method string      getCity()
 * @method self        setCity(string $city)
 * @method string      getPostalCode()
 * @method self        setPostalCode(string $postalCode)
 * @method string      getCountryCode()
 * @method self        setCountryCode(string $countryCode)
 */
class Address extends AbstractModel
{
    protected string $street;

    protected ?string $houseNumber = null;

    protected string $city;

    protected string $postalCode;

    protected string $countryCode;

    public function fromArray(array $data): self
    {
        $this->street = ResponseHelper::getStringNN($data, 'street');
        $this->houseNumber = ResponseHelper::getString($data, 'house_number');
        $this->city = ResponseHelper::getStringNN($data, 'city');
        $this->postalCode = ResponseHelper::getStringNN($data, 'postal_code');
        $this->countryCode = ResponseHelper::getStringNN($data, 'country');

        return $this;
    }

    protected function _toArray(): array
    {
        return [
            'street' => $this->street,
            'house_number' => $this->houseNumber,
            'city' => $this->city,
            'postal_code' => $this->postalCode,
            'country' => $this->countryCode,
        ];
    }

    protected function getFieldValidations(): array
    {
        return [
            'postalCode' => static function (self $object, $value = null): void {
                if (strlen((string) $value) !== 5) {
                    throw new InvalidFieldValueException('The field `postalCode` must be 5 chars long. (german postcode format)');
                }
            },
            'countryCode' => static function (self $object, $value = null): void {
                if (strlen((string) $value) !== 2) {
                    throw new InvalidFieldValueException('The field `countryCode` must be 2 chars long. (ISO-3166-1)');
                }
            },
        ];
    }
}
