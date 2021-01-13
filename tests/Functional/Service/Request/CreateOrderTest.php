<?php

namespace Billie\Sdk\Tests\Functional\Service\Request;

use Billie\Sdk\Exception\OrderDecline\DebtorLimitExceededException;
use Billie\Sdk\Exception\OrderDecline\DebtorNotIdentifiedException;
use Billie\Sdk\Exception\OrderDecline\InvalidDebtorAddressException;
use Billie\Sdk\Exception\OrderDecline\OrderDeclinedException;
use Billie\Sdk\Exception\OrderDecline\RiskPolicyDeclinedException;
use Billie\Sdk\HttpClient\BillieClient;
use Billie\Sdk\Model\Address;
use Billie\Sdk\Model\Amount;
use Billie\Sdk\Model\LineItem;
use Billie\Sdk\Model\Order;
use Billie\Sdk\Model\Person;
use Billie\Sdk\Model\Request\CreateOrder\Company;
use Billie\Sdk\Model\Request\CreateOrderRequestModel;
use Billie\Sdk\Service\Request\CreateOrderRequest;
use Billie\Sdk\Tests\Helper\BillieClientHelper;
use PHPUnit\Framework\TestCase;

class CreateOrderTest extends TestCase
{

    public function testCreateOrderWithValidAttributes()
    {
        $model = $this->createValidOrderModel();
        $requestService = new CreateOrderRequest(BillieClientHelper::getClient());
        $response = $requestService->execute($model);

        self::assertInstanceOf(Order::class, $response);
        self::assertNotNull($response->getUuid());
        self::assertEquals(Order::STATE_CREATED, $response->getState());
    }

    public function testCreateOrderDeclined()
    {
        $model = $this->createValidOrderModel();
        $model->getCompany()->setName('invalid company name');
        $requestService = new CreateOrderRequest(BillieClientHelper::getClient());

        try {
            $requestService->execute($model);
            self::fail('expected Exception of type ' . DebtorNotIdentifiedException::class);
            // we will not test every single declined-reason. Just the main functionality of throwing the exceptions
        } catch (OrderDeclinedException $exception) {
            self::assertNotNull($exception->getRequestModel());
            self::assertNotNull($exception->getDeclinedOrder());
            self::assertNotNull($exception->getDeclinedOrder()->getDeclineReason());
            self::assertEquals(Order::STATE_DECLINED, $exception->getDeclinedOrder()->getState());
        }
    }

    public function testDeclineOrderWithDebtorNotIdentifiedException()
    {
        $order = $this->createValidOrderModel();
        $order->getCompany()->setName('invalid company name');

        $billieClient = $this->createMock(BillieClient::class);
        $billieClient->method('request')->willReturn([
            'decline_reason' => Order::DECLINED_REASON_DEBTOR_NOT_IDENTIFIED
        ]);
        $requestService = new CreateOrderRequest($billieClient);

        $this->expectException(DebtorNotIdentifiedException::class);
        $requestService->execute($order);
    }

    public function testDeclineOrderWithDebtorAddressException()
    {
        $order = $this->createValidOrderModel();
        $order->getCompany()->getAddress()
            ->setStreet('invalid address')
            ->setCity('invalid address');

        $billieClient = $this->createMock(BillieClient::class);
        $billieClient->method('request')->willReturn([
            'decline_reason' => Order::DECLINED_REASON_INVALID_ADDRESS
        ]);
        $requestService = new CreateOrderRequest($billieClient);

        $this->expectException(InvalidDebtorAddressException::class);
        $requestService->execute($order);
    }

    public function testDeclineOrderWithRiskPolicyException()
    {
        $order = $this->createValidOrderModel();
        $order->getCompany()->getAddress()
            ->setStreet('invalid address')
            ->setCity('invalid address');

        $billieClient = $this->createMock(BillieClient::class);
        $billieClient->method('request')->willReturn([
            'decline_reason' => Order::DECLINED_REASON_RISK_POLICY
        ]);
        $requestService = new CreateOrderRequest($billieClient);

        $this->expectException(RiskPolicyDeclinedException::class);
        $requestService->execute($order);
    }

    public function testDeclineOrderWithLimitExceededException()
    {
        $order = $this->createValidOrderModel();
        $order->getCompany()->getAddress()
            ->setStreet('invalid address')
            ->setCity('invalid address');

        $billieClient = $this->createMock(BillieClient::class);
        $billieClient->method('request')->willReturn([
            'decline_reason' => Order::DECLINED_REASON_DEBTOR_LIMIT_EXCEEDED
        ]);
        $requestService = new CreateOrderRequest($billieClient);

        $this->expectException(DebtorLimitExceededException::class);
        $requestService->execute($order);
    }

    private function createValidOrderModel()
    {
        $orderId = uniqid('order-id-', true);
        $addressModel = (new Address())
            ->setStreet('Charlottenstr.')
            ->setHouseNumber('4')
            ->setAddition('c/o Mr. Smith')
            ->setPostalCode(10969)
            ->setCity('Berlin')
            ->setCountryCode('DE');

        return (new CreateOrderRequestModel())
            ->setOrderId($orderId)
            ->setBillingAddress($addressModel)
            ->setCompany(
                (new Company())
                    ->setMerchantCustomerId('BILLIE-00000001-1')
                    ->setName('Billie GmbH')
                    ->setAddress($addressModel)
                    ->setLegalForm('10001')
                    ->setRegistrationNumber('1234567')
                    ->setRegistrationCourt('Amtsgericht Charlottenburg')
            )
            ->setPerson(
                (new Person())
                    ->setMail('max.mustermann@musterfirma.de')
                    ->setSalutation('m')
                    ->setPhone('+4930120111111')
            )
            ->setDeliveryAddress($addressModel)
            ->setBillingAddress($addressModel)
            ->setAmount(
                (new Amount())
                    ->setGross(200.00)
                    ->setTaxRate(19.00)
            )
            ->setDuration(14)
            ->setComment('Test comment')
            ->addLineItem(
                (new LineItem())
                    ->setExternalId('product-id-1')
                    ->setTitle('product 1')
                    ->setDescription('description 1')
                    ->setCategory('category 1')
                    ->setBrand('brand 1')
                    ->setGtin('gtin 1')
                    ->setMpn('mpn 1')
                    ->setQuantity(2)
                    ->setAmount(
                        (new Amount())
                            ->setGross(50.00)
                            ->setTaxRate(19.00)
                    ))
            ->addLineItem(
                (new LineItem())
                    ->setExternalId('product-id-2')
                    ->setTitle('product 2')
                    ->setDescription('description 2')
                    ->setCategory('category 2')
                    ->setBrand('brand 2')
                    ->setGtin('gtin 2')
                    ->setMpn('mpn 2')
                    ->setQuantity(1)
                    ->setAmount(
                        (new Amount())
                            ->setGross(100.00)
                            ->setTaxRate(19.00)
                    )
            );
    }
}
