<?php
/*
 * Copyright (c) Billie GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Billie\Sdk\Tests\Acceptance\Model;

use Billie\Sdk\Model\Address;
use Billie\Sdk\Model\DebtorExternalData;

class DebtorExternalDataTest extends AbstractModelTestCase
{
    public function testFromArray(): void
    {
        $model = (new DebtorExternalData())
            ->fromArray([
                'merchant_customer_id' => 'customer-id',
                'name' => 'customer-name',
                'industry_sector' => 'industry',
                'address' => [],
            ]);

        static::assertEquals('customer-id', $model->getMerchantCustomerId());
        static::assertEquals('customer-name', $model->getName());
        static::assertEquals('industry', $model->getIndustrySector());
        static::assertInstanceOf(Address::class, $model->getAddress());
    }
}
