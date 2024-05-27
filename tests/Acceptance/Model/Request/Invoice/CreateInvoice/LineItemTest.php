<?php
/*
 * Copyright (c) Billie GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Billie\Sdk\Tests\Acceptance\Model\Request\Invoice\CreateInvoice;

use Billie\Sdk\Model\Amount;
use Billie\Sdk\Model\Request\Invoice\LineItem;
use Billie\Sdk\Tests\Acceptance\Model\AbstractModelTestCase;

class LineItemTest extends AbstractModelTestCase
{
    public function testToArray(): void
    {
        $data = $this->getValidModel()->toArray();

        static::assertIsArray($data);
        static::assertEquals('987654321', $data['external_id'] ?? null);
        static::assertEquals(5, $data['quantity'] ?? null);
        static::assertEquals(100, $data['amount_net']);
        static::assertEquals(119, $data['amount_gross']);
        static::assertEquals(19, $data['amount_tax']);
    }

    public function testFromArray(): void
    {
        static::assertTrue(true); // this is a request-model.
    }

    protected function getValidModel(): LineItem
    {
        return (new LineItem('123456789', 12))
            ->setExternalId('987654321')
            ->setQuantity(5)
            ->setAmount(
                (new Amount())
                    ->setGross(119)
                    ->setNet(100)
                    ->setTaxRate(19)
            );
    }
}
