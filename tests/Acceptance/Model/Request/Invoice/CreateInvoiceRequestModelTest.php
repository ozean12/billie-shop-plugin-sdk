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
use Billie\Sdk\Model\Request\Invoice\CreateInvoiceRequestModel;
use Billie\Sdk\Model\Request\Invoice\LineItem;
use Billie\Sdk\Model\ShippingInformation;
use Billie\Sdk\Tests\Acceptance\Model\AbstractModelTestCase;

class CreateInvoiceRequestModelTest extends AbstractModelTestCase
{
    public function testToArray(): void
    {
        $data = $this->getValidModel()->toArray();

        static::assertIsArray($data);
        static::assertCount(6, $data);
        static::assertIsArray($data['orders'] ?? null);
        static::assertCount(1, $data['orders']);
        static::assertEquals('order-123', $data['orders'][0] ?? null);
        static::assertEquals('invoice-123', $data['external_code'] ?? null);
        static::assertEquals('https://test.com/path/to/file.pdf', $data['invoice_url'] ?? null);
        static::assertIsArray($data['shipping_info'] ?? null);
        static::assertIsArray($data['amount'] ?? null);
        static::assertIsArray($data['line_items'] ?? null);
        static::assertCount(2, $data['line_items']);
        static::assertIsArray($data['line_items'][0] ?? null);
        static::assertIsArray($data['line_items'][1] ?? null);
    }

    public function testSetOrderExternalCode(): void
    {
        $model = $this->getValidModel();

        // reset array
        $model->setOrders([]);

        $model->setOrderExternalCode('test-123');

        $expectedArray = ['test-123'];

        self::assertEquals($expectedArray, $model->getOrders());
        self::assertEquals($expectedArray, $model->toArray()['orders'] ?? null);
    }

    public function testSetOrderUuId(): void
    {
        $model = $this->getValidModel();

        // reset array
        $model->setOrders([]);

        $model->setOrderUuId('test-123');

        $expectedArray = ['test-123'];

        self::assertEquals($expectedArray, $model->getOrders());
        self::assertEquals($expectedArray, $model->toArray()['orders'] ?? null);
    }

    public function testAddItems(): void
    {
        $model = $this->getValidModel();
        $model->disableValidateOnSet();

        // reset array
        $model->setLineItems([]);
        $model->addLineItem(new LineItem('test', 1));
        $model->addLineItem(new LineItem('test', 1));
        static::assertIsArray($model->getLineItems());
        static::assertCount(2, $model->getLineItems());

        $model->addLineItem(new LineItem('test', 1));
        static::assertCount(3, $model->getLineItems());
    }

    protected function getValidModel(): CreateInvoiceRequestModel
    {
        return (new CreateInvoiceRequestModel())
            ->setOrders(['order-123'])
            ->setInvoiceNumber('invoice-123')
            ->setInvoiceUrl('https://test.com/path/to/file.pdf')
            ->setShippingInformation(self::createModelMock(ShippingInformation::class))
            ->setAmount(self::createModelMock(Amount::class))
            ->setLineItems([
                self::createModelMock(LineItem::class),
                self::createModelMock(LineItem::class),
            ]);
    }
}
