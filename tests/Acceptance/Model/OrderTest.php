<?php
/*
 * Copyright (c) Billie GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Billie\Sdk\Tests\Acceptance\Model;

use Billie\Sdk\Model\Address;
use Billie\Sdk\Model\Amount;
use Billie\Sdk\Model\Debtor;
use Billie\Sdk\Model\Order;
use DateTime;

class OrderTest extends AbstractModelTestCase
{
    public function testFromArray(): void
    {
        $model = (new Order())
            ->fromArray([
                'external_code' => 'order-id',
                'uuid' => '123456',
                'state' => 'declined',
                'decline_reason' => 'risk_policy',
                'amount' => [],
                'unshipped_amount' => [],
                'duration' => 23,
                'created_at' => '2022-01-02 12:23:45',
                'delivery_address' => [],
                'debtor' => [],
                'invoices' => [],
                'selected_payment_method' => 'bank_transfer',
                'payment_methods' => [],
            ]);

        static::assertEquals('order-id', $model->getExternalCode());
        static::assertEquals('123456', $model->getUuid());
        static::assertEquals('risk_policy', $model->getDeclineReason());
        static::assertInstanceOf(Amount::class, $model->getAmount());
        static::assertInstanceOf(Amount::class, $model->getUnshippedAmount());
        static::assertEquals(23, $model->getDuration());
        static::assertInstanceOf(DateTime::class, $model->getCreatedAt());
        static::assertInstanceOf(Address::class, $model->getDeliveryAddress());
        static::assertInstanceOf(Debtor::class, $model->getDebtor());
        static::assertIsArray($model->getInvoices());
        static::assertEquals('bank_transfer', $model->getSelectedPaymentMethod());
        static::assertIsArray($model->getPaymentMethods());
    }
}
