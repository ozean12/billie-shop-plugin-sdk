<?php
/*
 * Copyright (c) Billie GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Billie\Sdk\Tests\Acceptance\Model\Request\Invoice;

use Billie\Sdk\Model\Amount;
use Billie\Sdk\Model\Request\Invoice\CreateInvoice\LineItem;
use Billie\Sdk\Model\Request\Invoice\CreateInvoiceRequestModel;
use Billie\Sdk\Model\ShippingInformation;
use Billie\Sdk\Tests\Acceptance\Model\AbstractModelTestCase;

class CreateInvoiceRequestModelTest extends AbstractModelTestCase
{
    public function testToArray(): void
    {
        $data = (new CreateInvoiceRequestModel())
            ->setOrders(['order-123'])
            ->setInvoiceNumber('invoice-123')
            ->setInvoiceUrl('https://test.com/path/to/file.pdf')
            ->setShippingInformation(self::createMock(ShippingInformation::class))
            ->setAmount(self::createMock(Amount::class))
            ->setLineItems([
                self::createMock(LineItem::class),
                self::createMock(LineItem::class),
            ])
            ->toArray();

        static::assertIsArray($data);
        static::assertCount(6, $data);
        static::assertIsArray($data['orders']);
        static::assertCount(1, $data['orders']);
        static::assertEquals('order-123', $data['orders'][0]);
        static::assertEquals('invoice-123', $data['external_code']);
        static::assertEquals('https://test.com/path/to/file.pdf', $data['invoice_url']);
        static::assertIsArray($data['shipping_info']);
        static::assertIsArray($data['amount']);
        static::assertIsArray($data['line_items']);
        static::assertCount(2, $data['line_items']);
        static::assertIsArray($data['line_items'][0]);
        static::assertIsArray($data['line_items'][1]);
    }

    public function testSetOrderExternalCode(): void
    {
        $model = $this->getValidModel();

        // reset array
        $model->setOrders([]);

        $model->setOrderExternalCode('test-123');

        $expectedArray = ['test-123'];

        self::assertEquals($expectedArray, $model->getOrders());
        self::assertEquals($expectedArray, $model->toArray()['orders']);
    }

    public function testSetOrderUuId(): void
    {
        $model = $this->getValidModel();

        // reset array
        $model->setOrders([]);

        $model->setOrderUuId('test-123');

        $expectedArray = ['test-123'];

        self::assertEquals($expectedArray, $model->getOrders());
        self::assertEquals($expectedArray, $model->toArray()['orders']);
    }

    private function getValidModel(): CreateInvoiceRequestModel
    {
        return (new CreateInvoiceRequestModel())
            ->setOrders(['order-123'])
            ->setInvoiceNumber('invoice-123')
            ->setInvoiceUrl('https://test.com/path/to/file.pdf')
            ->setShippingInformation(self::createMock(ShippingInformation::class))
            ->setAmount(self::createMock(Amount::class))
            ->setLineItems([
                self::createMock(LineItem::class),
                self::createMock(LineItem::class),
            ]);
    }
}
