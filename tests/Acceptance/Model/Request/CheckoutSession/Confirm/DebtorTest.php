<?php
/*
 * Copyright (c) Billie GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Billie\Sdk\Tests\Acceptance\Model\Request\CheckoutSession\Confirm;

use Billie\Sdk\Model\Address;
use Billie\Sdk\Model\Request\CheckoutSession\Confirm\Debtor;
use Billie\Sdk\Tests\Acceptance\Model\Request\AbstractRequestModelTest;

class DebtorTest extends AbstractRequestModelTest
{
    public function testToArray(): void
    {
        $data = (new Debtor())
            ->setName('debtor-name')
            ->setAddress(self::createMock(Address::class))
            ->toArray();

        static::assertIsArray($data);
        static::assertCount(2, $data);
        static::assertEquals('debtor-name', $data['name']);
        static::assertIsArray($data['company_address']);
    }
}
