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
 * @method self   setSalutation(string $salutation)
 * @method string|null getSalutation()
 * @method self   setFirstname(string $firstname)
 * @method string|null getFirstname()
 * @method self   setLastname(string $lastname)
 * @method string|null getLastname()
 * @method self   setPhone(string $phone)
 * @method string|null getPhone()
 * @method self   setMail(string $mail)
 * @method string getMail()
 */
class Person extends AbstractModel
{
    protected static array $_additionalFieldMapping = [
        'mail' => 'email',
        'phone' => 'phone_number',
        'firstname' => 'first_name',
        'lastname' => 'last_name',
    ];

    protected ?string $salutation = null;

    protected ?string $firstname = null;

    protected ?string $lastname = null;

    protected ?string $phone = null;

    protected string $mail;

    protected function getFieldValidations(): array
    {
        return [
            'salutation' => static function (self $object, $value): void {
                if (!in_array($value, ['m', 'f'], true)) {
                    throw new InvalidFieldValueException('the field value of `salutation` must be one of these: `m`, `f`');
                }
            },
        ];
    }
}
