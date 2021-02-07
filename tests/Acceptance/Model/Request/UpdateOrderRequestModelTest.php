<?php


namespace Billie\Sdk\Tests\Acceptance\Model\Request;


use Billie\Sdk\Model\Amount;
use Billie\Sdk\Model\Request\UpdateOrderRequestModel;
use Billie\Sdk\Tests\Acceptance\Model\AbstractModelTestCase;

class UpdateOrderRequestModelTest extends AbstractModelTestCase
{

    public function testToArray()
    {
        $data = (new UpdateOrderRequestModel('uuid'))
            ->setInvoiceNumber('123456789')
            ->setInvoiceUrl('https://domain.com/path/invoice.pdf')
            ->setOrderId('order-id')
            ->setDuration(123)
            ->setAmount($this->createMock(Amount::class))
            ->toArray();

        self::assertCount(5, $data); // uuid should not be returned
        self::assertEquals('123456789', $data['invoice_number']);
        self::assertEquals('https://domain.com/path/invoice.pdf', $data['invoice_url']);
        self::assertEquals('order-id', $data['order_id']);
        self::assertEquals(123, $data['duration']);
        self::assertInternalType('array', $data['amount']);
    }

}