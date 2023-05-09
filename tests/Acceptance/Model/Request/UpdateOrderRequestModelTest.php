<?php

declare(strict_types=1);

namespace Billie\Sdk\Tests\Acceptance\Model\Request;

use Billie\Sdk\Model\Amount;
use Billie\Sdk\Model\Request\UpdateOrderRequestModel;
use Billie\Sdk\Tests\Acceptance\Model\AbstractModelTestCase;

class UpdateOrderRequestModelTest extends AbstractModelTestCase
{
    public function testToArray(): void
    {
        $data = (new UpdateOrderRequestModel('uuid'))
            ->setInvoiceNumber('123456789')
            ->setInvoiceUrl('https://domain.com/path/invoice.pdf')
            ->setOrderId('order-id')
            ->setDuration(123)
            ->setAmount($this->createMock(Amount::class))
            ->toArray();

        static::assertCount(5, $data); // uuid should not be returned
        static::assertEquals('123456789', $data['invoice_number']);
        static::assertEquals('https://domain.com/path/invoice.pdf', $data['invoice_url']);
        static::assertEquals('order-id', $data['order_id']);
        static::assertEquals(123, $data['duration']);
        static::assertIsArray($data['amount']);
    }
}
