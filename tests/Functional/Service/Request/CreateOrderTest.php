<?php
/*
 * Copyright (c) Billie GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Billie\Sdk\Tests\Functional\Service\Request;

use Billie\Sdk\Exception\OrderDecline\DebtorLimitExceededException;
use Billie\Sdk\Exception\OrderDecline\DebtorNotIdentifiedException;
use Billie\Sdk\Exception\OrderDecline\InvalidDebtorAddressException;
use Billie\Sdk\Exception\OrderDecline\OrderDeclinedException;
use Billie\Sdk\Exception\OrderDecline\RiskPolicyDeclinedException;
use Billie\Sdk\HttpClient\BillieClient;
use Billie\Sdk\Model\Order;
use Billie\Sdk\Service\Request\CreateOrderRequest;
use Billie\Sdk\Tests\Helper\BillieClientHelper;
use Billie\Sdk\Tests\Helper\OrderHelper;
use PHPUnit\Framework\TestCase;

class CreateOrderTest extends TestCase
{
    public function testCreateOrderWithValidAttributes(): void
    {
        $model = OrderHelper::createValidOrderModel();
        $requestService = new CreateOrderRequest(BillieClientHelper::getClient());
        $response = $requestService->execute($model);

        static::assertInstanceOf(Order::class, $response);
        static::assertNotNull($response->getUuid());
        static::assertEquals(Order::STATE_CREATED, $response->getState());
    }

    public function testCreateOrderDeclined(): void
    {
        $model = OrderHelper::createValidOrderModel();
        $model->getCompany()->setName('invalid company name');
        $requestService = new CreateOrderRequest(BillieClientHelper::getClient());

        try {
            $requestService->execute($model);
            static::fail('expected Exception of type ' . DebtorNotIdentifiedException::class);
            // we will not test every single declined-reason. Just the main functionality of throwing the exceptions
        } catch (OrderDeclinedException $orderDeclinedException) {
            static::assertNotNull($orderDeclinedException->getRequestModel());
            static::assertNotNull($orderDeclinedException->getDeclinedOrder());
            static::assertNotNull($orderDeclinedException->getDeclinedOrder()->getDeclineReason());
            static::assertEquals(Order::STATE_DECLINED, $orderDeclinedException->getDeclinedOrder()->getState());
        }
    }

    public function testDeclineOrderWithDebtorNotIdentifiedException(): void
    {
        $order = OrderHelper::createValidOrderModel();
        $order->getCompany()->setName('invalid company name');

        $billieClient = $this->createMock(BillieClient::class);
        $billieClient->method('request')->willReturn([
            'decline_reason' => Order::DECLINED_REASON_DEBTOR_NOT_IDENTIFIED,
        ]);
        $requestService = new CreateOrderRequest($billieClient);

        $this->expectException(DebtorNotIdentifiedException::class);
        $requestService->execute($order);
    }

    public function testDeclineOrderWithDebtorAddressException(): void
    {
        $order = OrderHelper::createValidOrderModel();
        $order->getCompany()->getAddress()
            ->setStreet('invalid address')
            ->setCity('invalid address');

        $billieClient = $this->createMock(BillieClient::class);
        $billieClient->method('request')->willReturn([
            'decline_reason' => Order::DECLINED_REASON_INVALID_ADDRESS,
        ]);
        $requestService = new CreateOrderRequest($billieClient);

        $this->expectException(InvalidDebtorAddressException::class);
        $requestService->execute($order);
    }

    public function testDeclineOrderWithRiskPolicyException(): void
    {
        $order = OrderHelper::createValidOrderModel();
        $order->getCompany()->getAddress()
            ->setStreet('invalid address')
            ->setCity('invalid address');

        $billieClient = $this->createMock(BillieClient::class);
        $billieClient->method('request')->willReturn([
            'decline_reason' => Order::DECLINED_REASON_RISK_POLICY,
        ]);
        $requestService = new CreateOrderRequest($billieClient);

        $this->expectException(RiskPolicyDeclinedException::class);
        $requestService->execute($order);
    }

    public function testDeclineOrderWithLimitExceededException(): void
    {
        $order = OrderHelper::createValidOrderModel();
        $order->getCompany()->getAddress()
            ->setStreet('invalid address')
            ->setCity('invalid address');

        $billieClient = $this->createMock(BillieClient::class);
        $billieClient->method('request')->willReturn([
            'decline_reason' => Order::DECLINED_REASON_DEBTOR_LIMIT_EXCEEDED,
        ]);
        $requestService = new CreateOrderRequest($billieClient);

        $this->expectException(DebtorLimitExceededException::class);
        $requestService->execute($order);
    }
}
