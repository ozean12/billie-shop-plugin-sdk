<?php
/*
 * Copyright (c) Billie GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Billie\Sdk\Tests\Acceptance\Model;

use Billie\Sdk\Model\AbstractModel;
use Billie\Sdk\Model\DebtorExternalData;
use Billie\Sdk\Tests\Functional\Util\ValidModelGenerator;

class DebtorExternalDataTest extends AbstractModelTestCase
{
    public function testToArray(): void
    {
        // nothing to test, cause there are no setters
        static::assertTrue(true);
    }

    protected function getValidModel(): AbstractModel
    {
        // does not make so much cause the method `getValidModel` is used for testing the `fromArray` method.
        // but the behaviour is tested :)
        return (new DebtorExternalData())
            ->fromArray([
                'merchant_customer_id' => 'customer-id',
                'name' => 'customer-name',
                'industry_sector' => 'industry',
                'address' => ValidModelGenerator::createValidAddress()->toArray(),
            ]);
    }
}
