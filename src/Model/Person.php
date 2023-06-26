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
    protected ?string $salutation = null;

    protected ?string $firstname = null;

    protected ?string $lastname = null;

    protected ?string $phone = null;

    protected string $mail;

    public function fromArray(array $data): self
    {
        $this->mail = ResponseHelper::getStringNN($data, 'email');
        $this->salutation = ResponseHelper::getString($data, 'salutation');
        $this->firstname = ResponseHelper::getString($data, 'first_name');
        $this->lastname = ResponseHelper::getString($data, 'last_name');
        $this->phone = ResponseHelper::getString($data, 'phone_number');

        return $this;
    }

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

    protected function _toArray(): array
    {
        return [
            'email' => $this->mail,
            'salutation' => $this->salutation,
            'first_name' => $this->firstname,
            'last_name' => $this->lastname,
            'phone_number' => $this->phone,
        ];
    }
}
