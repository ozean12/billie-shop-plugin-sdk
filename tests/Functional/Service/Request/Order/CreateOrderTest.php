<?php
/*
 * Copyright (c) Billie GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Billie\Sdk\Tests\Functional\Service\Request\Order;

use Billie\Sdk\Exception\OrderDecline\DebtorLimitExceededException;
use Billie\Sdk\Exception\OrderDecline\DebtorNotIdentifiedException;
use Billie\Sdk\Exception\OrderDecline\InvalidDebtorAddressException;
use Billie\Sdk\Exception\OrderDecline\OrderDeclinedException;
use Billie\Sdk\Exception\OrderDecline\RiskPolicyDeclinedException;
use Billie\Sdk\HttpClient\BillieClient;
use Billie\Sdk\Model\Order;
use Billie\Sdk\Service\Request\Order\CreateOrderRequest;
use Billie\Sdk\Tests\Functional\Service\Request\AbstractOrderRequest;
use Billie\Sdk\Tests\Helper\BillieClientHelper;
use Billie\Sdk\Tests\Helper\OrderHelper;

class CreateOrderTest extends AbstractOrderRequest
{
    private static array $declinedResponseTemplate = [
        'external_code' => '123',
        'state' => Order::STATE_DECLINED,
        'amount' => [],
        'unshipped_amount' => [],
        'duration' => 123,
        'debtor' => [],
        'delivery_address' => [],
        'created_at' => '2022-12-13 12:34:56',
        'invoices' => [],
        'selected_payment_method' => 'payment-method',
        'payment_methods' => [],
        'uuid' => '123',
    ];

    public function testCreateOrderWithValidAttributes(): void
    {
        $model = OrderHelper::createValidOrderModel($this->getName());
        $requestService = new CreateOrderRequest(BillieClientHelper::getClient());
        $response = $requestService->execute($model);
        $this->orderIds[] = $response->getUuid(); // house-keeping

        static::assertInstanceOf(Order::class, $response);
        static::assertNotNull($response->getUuid());
        static::assertEquals(Order::STATE_CREATED, $response->getState());
    }

    public function testCreateOrderDeclined(): void
    {
        $model = OrderHelper::createValidOrderModel($this->getName());
        $model->getDebtor()->setName('invalid company name');
        $requestService = new CreateOrderRequest(BillieClientHelper::getClient());

        try {
            $response = $requestService->execute($model);
            $this->orderIds[] = $response->getUuid(); // house-keeping
            static::fail('expected Exception of type ' . DebtorNotIdentifiedException::class);
            // we will not test every single declined-reason. Just the main functionality of throwing the exceptions
        } catch (OrderDeclinedException $orderDeclinedException) {
            static::assertNotNull($orderDeclinedException->getRequestModel());
            static::assertNotNull($orderDeclinedException->getDeclinedOrder());
            static::assertEmpty($orderDeclinedException->getDeclinedOrder()->getDebtor()->getName());
            static::assertNotNull($orderDeclinedException->getDeclinedOrder()->getDeclineReason());
            static::assertEquals(Order::STATE_DECLINED, $orderDeclinedException->getDeclinedOrder()->getState());
        }
    }

    public function testDeclineOrderWithDebtorNotIdentifiedException(): void
    {
        $order = OrderHelper::createValidOrderModel();

        $billieClient = $this->createMock(BillieClient::class);
        $billieClient->method('request')->willReturn(array_merge(
            self::$declinedResponseTemplate,
            [
                'decline_reason' => Order::DECLINED_REASON_DEBTOR_NOT_IDENTIFIED,
            ]
        ));
        $requestService = new CreateOrderRequest($billieClient);

        $this->expectException(DebtorNotIdentifiedException::class);
        $requestService->execute($order);
    }

    public function testDeclineOrderWithDebtorAddressException(): void
    {
        $order = OrderHelper::createValidOrderModel();

        $billieClient = $this->createMock(BillieClient::class);
        $billieClient->method('request')->willReturn(array_merge(
            self::$declinedResponseTemplate,
            [
                'decline_reason' => Order::DECLINED_REASON_INVALID_ADDRESS,
            ]
        ));
        $requestService = new CreateOrderRequest($billieClient);

        $this->expectException(InvalidDebtorAddressException::class);
        $requestService->execute($order);
    }

    public function testDeclineOrderWithRiskPolicyException(): void
    {
        $order = OrderHelper::createValidOrderModel();

        $billieClient = $this->createMock(BillieClient::class);
        $billieClient->method('request')->willReturn(array_merge(
            self::$declinedResponseTemplate,
            [
                'decline_reason' => Order::DECLINED_REASON_RISK_POLICY,
            ]
        ));
        $requestService = new CreateOrderRequest($billieClient);

        $this->expectException(RiskPolicyDeclinedException::class);
        $requestService->execute($order);
    }

    public function testDeclineOrderWithLimitExceededException(): void
    {
        $order = OrderHelper::createValidOrderModel();

        $billieClient = $this->createMock(BillieClient::class);

        $billieClient->method('request')->willReturn(array_merge(
            self::$declinedResponseTemplate,
            [
                'decline_reason' => Order::DECLINED_REASON_DEBTOR_LIMIT_EXCEEDED,
            ]
        ));
        $requestService = new CreateOrderRequest($billieClient);

        $this->expectException(DebtorLimitExceededException::class);
        $requestService->execute($order);
    }
}
