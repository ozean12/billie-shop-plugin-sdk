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
use Billie\Sdk\Model\LineItem;
use Billie\Sdk\Tests\Functional\Util\ValidModelGenerator;

class LineItemTest extends AbstractModelTestCase
{
    public function testToArray(): void
    {
        $data = $this->getValidModel()->toArray();

        static::assertEquals('external-product-id', $data['external_id'] ?? null);
        static::assertIsArray($data['amount'] ?? null);
        static::assertEquals('title-value', $data['title'] ?? null);
        static::assertEquals(123, $data['quantity'] ?? null);
        static::assertEquals('description text', $data['description'] ?? null);
        static::assertEquals('category-name', $data['category'] ?? null);
        static::assertEquals('brand-name', $data['brand'] ?? null);
        static::assertEquals('gtin-value', $data['gtin'] ?? null);
        static::assertEquals('mpn-value', $data['mpn'] ?? null);
    }

    protected function getValidModel(): AbstractModel
    {
        return (new LineItem())
            ->setExternalId('external-product-id')
            ->setAmount(ValidModelGenerator::createAmount())
            ->setBrand('brand-name')
            ->setCategory('category-name')
            ->setDescription('description text')
            ->setGtin('gtin-value')
            ->setMpn('mpn-value')
            ->setQuantity(123)
            ->setTitle('title-value');
    }
}
