<?php


namespace Billie\Sdk\Tests\Acceptance\Model;

use Billie\Sdk\Model\Amount;
use Billie\Sdk\Model\LineItem;
use PHPUnit\Framework\TestCase;

class LineItemTest extends TestCase
{

    public function testToArray()
    {
        $data = (new LineItem())
            ->setExternalId('external-product-id')
            ->setAmount(new Amount())
            ->setBrand('brand-name')
            ->setCategory('category-name')
            ->setDescription('description text')
            ->setGtin('gtin-value')
            ->setMpn('mpn-value')
            ->setQuantity(123)
            ->setTitle('title-value')
            ->toArray();

        self::assertEquals('external-product-id', $data['external_id']);
        self::assertInternalType('array', $data['amount']);
        self::assertEquals('title-value', $data['title']);
        self::assertEquals(123, $data['quantity']);
        self::assertEquals('description text', $data['description']);
        self::assertEquals('category-name', $data['category']);
        self::assertEquals('brand-name', $data['brand']);
        self::assertEquals('gtin-value', $data['gtin']);
        self::assertEquals('mpn-value', $data['mpn']);
    }

}