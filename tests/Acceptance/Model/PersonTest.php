<?php
/*
 * Copyright (c) Billie GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Billie\Sdk\Tests\Acceptance\Model;

use Billie\Sdk\Exception\Validation\InvalidFieldValueException;
use Billie\Sdk\Model\AbstractModel;
use Billie\Sdk\Model\Person;

class PersonTest extends AbstractModelTestCase
{
    public function testToArray(): void
    {
        $data = $this->getValidModel()->toArray();

        static::assertEquals('first name', $data['first_name'] ?? null);
        static::assertEquals('last name', $data['last_name'] ?? null);
        static::assertEquals('e-mail', $data['email'] ?? null);
        static::assertEquals('0123456789', $data['phone_number'] ?? null);
        static::assertEquals('m', $data['salutation'] ?? null);
    }

    public function testInvalidSalutation(): void
    {
        // test valid
        (new Person())
            ->setValidateOnSet(true)
            ->setSalutation('m');

        // test invalid
        static::expectException(InvalidFieldValueException::class);
        static::expectExceptionMessageMatches('/^the field value of `salutation` must be one of these.*/');

        (new Person())
            ->setValidateOnSet(true)
            ->setSalutation('x');
    }

    protected function getValidModel(): AbstractModel
    {
        return (new Person())
            ->setFirstname('first name')
            ->setLastname('last name')
            ->setMail('e-mail')
            ->setPhone('0123456789')
            ->setSalutation('m');
    }
}
