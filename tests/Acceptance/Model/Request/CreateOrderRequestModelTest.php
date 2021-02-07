<?php

namespace Billie\Sdk\Tests\Acceptance\Model\Request;


use Billie\Sdk\Model\Address;
use Billie\Sdk\Model\Amount;
use Billie\Sdk\Model\LineItem;
use Billie\Sdk\Model\Person;
use Billie\Sdk\Model\Request\CreateOrder\Company;
use Billie\Sdk\Model\Request\CreateOrderRequestModel;
use Billie\Sdk\Tests\Acceptance\Model\AbstractModelTestCase;

class CreateOrderRequestModelTest extends AbstractModelTestCase
{

    public function testToArray()
    {
        $data = (new CreateOrderRequestModel())
            ->setAmount($this->createMock(Amount::class))
            ->setDuration(12)
            ->setCompany($this->createMock(Company::class))
            ->setPerson($this->createMock(Person::class))
            ->setComment('test-comment')
            ->setOrderId('test-order-id')
            ->setDeliveryAddress($this->createMock(Address::class))
            ->setBillingAddress($this->createMock(Address::class))
            ->setLineItems([$this->createMock(LineItem::class), $this->createMock(LineItem::class)])
            ->toArray();

        self::assertInternalType('array', $data['amount']);
        self::assertEquals(12, $data['duration']);
        self::assertInternalType('array', $data['debtor_company']);
        self::assertInternalType('array', $data['debtor_person']);
        self::assertEquals('test-comment', $data['comment']);
        self::assertEquals('test-order-id', $data['order_id']);
        self::assertInternalType('array', $data['delivery_address']);
        self::assertInternalType('array', $data['billing_address']);
        self::assertInternalType('array', $data['line_items']);
        self::assertCount(2, $data['line_items']);
    }
}