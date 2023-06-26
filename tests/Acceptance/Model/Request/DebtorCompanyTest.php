<?php
/*
 * Copyright (c) Billie GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Billie\Sdk\Tests\Acceptance\Model\Request;

use Billie\Sdk\Model\AbstractModel;
use Billie\Sdk\Model\Request\Widget\DebtorCompany;
use Billie\Sdk\Tests\Acceptance\Model\AbstractModelTestCase;
use Billie\Sdk\Tests\Functional\Util\ValidModelGenerator;

class DebtorCompanyTest extends AbstractModelTestCase
{
    public function testToArray(): void
    {
        $data = $this->getValidModel()->toArray();

        static::assertIsArray($data);
        static::assertCount(7, $data); // special-case: address got flatten
        static::assertEquals('name', $data['name'] ?? null);
        static::assertTrue($data['established_customer'] ?? null);

        $validAddress = ValidModelGenerator::createValidAddress();
        static::assertEquals($validAddress->getStreet(), $data['address_street'] ?? null);
        static::assertEquals($validAddress->getHouseNumber(), $data['address_house_number'] ?? null);
        static::assertEquals($validAddress->getCity(), $data['address_city'] ?? null);
        static::assertEquals($validAddress->getPostalCode(), $data['address_postal_code'] ?? null);
        static::assertEquals($validAddress->getCountryCode(), $data['address_country'] ?? null);
    }

    protected function getValidModel(): AbstractModel
    {
        return (new DebtorCompany())
            ->setName('name')
            ->setEstablishedCustomer(true)
            ->setAddress(ValidModelGenerator::createValidAddress());
    }
}
