<?php

namespace Billie\Sdk\Tests\Acceptance\Model\Request;


use Billie\Sdk\Model\Address;
use Billie\Sdk\Model\Amount;
use Billie\Sdk\Model\LineItem;
use Billie\Sdk\Model\Person;
use Billie\Sdk\Model\Request\CreateOrder\Company;
use Billie\Sdk\Model\Request\CreateOrderRequestModel;
use PHPUnit\Framework\TestCase;

class CreateOrderRequestModelTest extends TestCase
{

    public function testToArray()
    {
        $data = (new CreateOrderRequestModel())
            ->setAmount(new Amount())
            ->setDuration(12)
            ->setCompany(
                (new Company())
                    ->setAddress(new Address())
            )
            ->setPerson(new Person())
            ->setComment('test-comment')
            ->setOrderId('test-order-id')
            ->setDeliveryAddress(new Address())
            ->setBillingAddress(new Address())
            ->setLineItems([(new LineItem())->setAmount(new Amount()), (new LineItem())->setAmount(new Amount())])
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