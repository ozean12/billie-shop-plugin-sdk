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
use Billie\Sdk\Tests\Acceptance\Model\Request\AbstractRequestModelTestCase;

class DebtorTest extends AbstractRequestModelTestCase
{
    public function testToArray(): void
    {
        $data = $this->getValidModel()->toArray();

        static::assertIsArray($data);
        static::assertCount(2, $data);
        static::assertEquals('debtor-name', $data['name'] ?? null);
        static::assertIsArray($data['company_address'] ?? null);
    }

    protected function getValidModel(): Debtor
    {
        return (new Debtor())
            ->setName('debtor-name')
            ->setAddress($this->createMock(Address::class));
    }
}
