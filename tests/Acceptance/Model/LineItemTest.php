<?php
/*
 * Copyright (c) Billie GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Billie\Sdk\Tests\Acceptance\Model;

use Billie\Sdk\Model\Amount;
use Billie\Sdk\Model\LineItem;

class LineItemTest extends AbstractModelTestCase
{
    public function testToArray(): void
    {
        $data = (new LineItem())
            ->setExternalId('external-product-id')
            ->setAmount($this->createMock(Amount::class))
            ->setBrand('brand-name')
            ->setCategory('category-name')
            ->setDescription('description text')
            ->setGtin('gtin-value')
            ->setMpn('mpn-value')
            ->setQuantity(123)
            ->setTitle('title-value')
            ->toArray();

        static::assertEquals('external-product-id', $data['external_id']);
        static::assertIsArray($data['amount']);
        static::assertEquals('title-value', $data['title']);
        static::assertEquals(123, $data['quantity']);
        static::assertEquals('description text', $data['description']);
        static::assertEquals('category-name', $data['category']);
        static::assertEquals('brand-name', $data['brand']);
        static::assertEquals('gtin-value', $data['gtin']);
        static::assertEquals('mpn-value', $data['mpn']);
    }
}
