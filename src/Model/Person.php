<?php

namespace Billie\Sdk\Model;

use Billie\Sdk\Exception\Validation\InvalidFieldValueException;

/**
 * @method self setSalutation(string $salutation)
 * @method string getSalutation(string $salutation)
 * @method self setFirstname(string $firstname)
 * @method string getFirstname(string $firstname)
 * @method self setLastname(string $lastname)
 * @method string getLastname(string $lastname)
 * @method self setPhone(string $phone)
 * @method string getPhone(string $phone)
 * @method self setMail(string $mail)
 * @method string getMail(string $mail)
 */
class Person extends AbstractModel
{
    /**
     * @var string
     */
    protected $salutation;

    /**
     * @var string
     */
    protected $firstname;

    /**
     * @var string
     */
    protected $lastname;

    /**
     * @var string
     */
    protected $phone;

    /**
     * @var string email
     */
    protected $mail;


    public function getFieldValidations()
    {
        return [
            'salutation' => static function (self $object, $value) {
                if (in_array($value, ['m', 'f'], true) === false) {
                    throw new InvalidFieldValueException('the field value of `salutation` must be one of these: `m`, `f`');
                }
            },
            'firstname' => '?string',
            'lastname' => '?string',
            'phone' => '?string',
            'mail' => '?string',
        ];
    }

    public function toArray()
    {
        return [
            'email' => $this->mail,
            'salutation' => $this->salutation,
            'first_name' => $this->firstname,
            'last_name' => $this->lastname,
            'phone_number' => $this->phone,
        ];
    }

    public function fromArray($data)
    {
        // TODO: Implement fromArray() method.
    }
}