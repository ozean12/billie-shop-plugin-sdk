<?php

declare(strict_types=1);

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
    public function testToArray(): void
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

        static::assertIsArray($data['amount']);
        static::assertEquals(12, $data['duration']);
        static::assertIsArray($data['debtor_company']);
        static::assertIsArray($data['debtor_person']);
        static::assertEquals('test-comment', $data['comment']);
        static::assertEquals('test-order-id', $data['order_id']);
        static::assertIsArray($data['delivery_address']);
        static::assertIsArray($data['billing_address']);
        static::assertIsArray($data['line_items']);
        static::assertCount(2, $data['line_items']);
    }
}
