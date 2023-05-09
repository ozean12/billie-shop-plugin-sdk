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
 * @method string|null getAddition()
 * @method self        setAddition(?string $addition)
 * @method string      getCity()
 * @method self        setCity(string $city)
 * @method string      getPostalCode()
 * @method self        setPostalCode(string $postalCode)
 * @method string      getCountryCode()
 * @method self        setCountryCode(string $countryCode)
 */
class Address extends AbstractModel
{
    protected ?string $street = null;

    protected ?string $houseNumber = null;

    protected ?string $addition = null;

    protected ?string $city = null;

    protected ?string $postalCode = null;

    protected ?string $countryCode = null;

    public function fromArray(array $data): self
    {
        $this->street = ResponseHelper::getString($data, 'street');
        $this->houseNumber = ResponseHelper::getString($data, 'house_number');
        $this->addition = ResponseHelper::getString($data, 'addition');
        $this->city = ResponseHelper::getString($data, 'city');
        $this->postalCode = ResponseHelper::getString($data, 'postal_code');
        $this->countryCode = ResponseHelper::getString($data, 'country');

        return $this;
    }

    public function toArray(): array
    {
        return [
            'street' => $this->street,
            'house_number' => $this->houseNumber,
            'addition' => $this->addition,
            'city' => $this->city,
            'postal_code' => $this->postalCode,
            'country' => $this->countryCode,
        ];
    }

    public function getFieldValidations(): array
    {
        return [
            'street' => 'string',
            'houseNumber' => '?string',
            'addition' => '?string',
            'city' => 'string',
            'postalCode' => static function (self $object, $value): void {
                if (strlen($value) !== 5) {
                    throw new InvalidFieldValueException('The field `postalCode` must be 5 chars long. (german postcode format)');
                }
            },
            'countryCode' => static function (self $object, $value): string {
                if (strlen($value) !== 2) {
                    throw new InvalidFieldValueException('The field `countryCode` must be 2 chars long. (ISO-3166-1)');
                }

                return 'string';
            },
        ];
    }
}
