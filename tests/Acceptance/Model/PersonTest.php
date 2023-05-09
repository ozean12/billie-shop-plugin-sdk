<?php

declare(strict_types=1);

namespace Billie\Sdk\Tests\Acceptance\Model;

use Billie\Sdk\Exception\Validation\InvalidFieldValueException;
use Billie\Sdk\Model\Person;

class PersonTest extends AbstractModelTestCase
{
    public function testToArray(): void
    {
        $data = (new Person())
            ->setFirstname('first name')
            ->setLastname('last name')
            ->setMail('e-mail')
            ->setPhone('0123456789')
            ->setSalutation('m')
            ->toArray();

        static::assertEquals('first name', $data['first_name']);
        static::assertEquals('last name', $data['last_name']);
        static::assertEquals('e-mail', $data['email']);
        static::assertEquals('0123456789', $data['phone_number']);
        static::assertEquals('m', $data['salutation']);
    }

    public function testInvalidSalutation(): void
    {
        $this->expectException(InvalidFieldValueException::class);

        (new Person())
            ->setSalutation('x')
            ->toArray();
    }
}
