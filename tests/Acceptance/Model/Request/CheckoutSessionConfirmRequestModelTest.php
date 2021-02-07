<?php


namespace Billie\Sdk\Tests\Acceptance\Model\Request;


use Billie\Sdk\Model\Address;
use Billie\Sdk\Model\Amount;
use Billie\Sdk\Model\DebtorCompany;
use Billie\Sdk\Model\Request\CheckoutSessionConfirmRequestModel;
use Billie\Sdk\Tests\Acceptance\Model\AbstractModelTestCase;

class CheckoutSessionConfirmRequestModelTest extends AbstractModelTestCase
{

    public function testToArray()
    {
        $data = (new CheckoutSessionConfirmRequestModel())
            ->setSessionUuid('session-uuid')
            ->setAmount($this->createMock(Amount::class))
            ->setCompany($this->createMock(DebtorCompany::class))
            ->setDeliveryAddress($this->createMock(Address::class))
            ->setDuration(12)
            ->setOrderId('test-order-id')
            ->toArray();

        self::assertCount(5, $data); // session-uuid should not be in the data array
        self::assertInternalType('array', $data['amount']);
        self::assertInternalType('array', $data['debtor_company']);
        self::assertInternalType('array', $data['delivery_address']);
        self::assertEquals(12, $data['duration']);
        self::assertEquals('test-order-id', $data['order_id']);
    }
}