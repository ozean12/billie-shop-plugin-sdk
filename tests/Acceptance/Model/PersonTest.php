<?php


namespace Billie\Sdk\Tests\Acceptance\Model;

use Billie\Sdk\Exception\Validation\InvalidFieldValueException;
use Billie\Sdk\Model\Person;
use PHPUnit\Framework\TestCase;

class PersonTest extends TestCase
{

    public function testToArray()
    {
        $data = (new Person())
            ->setFirstname('first name')
            ->setLastname('last name')
            ->setMail('e-mail')
            ->setPhone('0123456789')
            ->setSalutation('m')
            ->toArray();

        self::assertEquals('first name', $data['first_name']);
        self::assertEquals('last name', $data['last_name']);
        self::assertEquals('e-mail', $data['email']);
        self::assertEquals('0123456789', $data['phone_number']);
        self::assertEquals('m', $data['salutation']);
    }

    public function testInvalidSalutation() {

        $this->expectException(InvalidFieldValueException::class);

        (new Person())
            ->setSalutation('x')
            ->toArray();
    }


}