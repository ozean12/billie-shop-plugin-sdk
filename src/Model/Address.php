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
    protected static array $_additionalFieldMapping = [
        'countryCode' => 'country',
    ];

    protected string $street;

    protected ?string $houseNumber = null;

    protected string $city;

    protected string $postalCode;

    protected string $countryCode;

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
