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
use Billie\Sdk\Model\Invoice;
use Billie\Sdk\Model\Order;
use Billie\Sdk\Model\OrderPaymentMethod;
use Billie\Sdk\Util\ResponseHelper;
use DateTime;

class OrderTest extends AbstractModelTestCase
{
    public function testToArray(): void
    {
        // nothing to test, cause there are no setters
        static::assertTrue(true);
    }

    public function testFromArray(): void
    {
        $model = $this->getValidModel();

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
        static::assertContainsOnlyInstancesOf(Invoice::class, $model->getInvoices());
        static::assertEquals('bank_transfer', $model->getSelectedPaymentMethod());
        static::assertIsArray($model->getPaymentMethods());
        static::assertContainsOnlyInstancesOf(OrderPaymentMethod::class, $model->getPaymentMethods());
    }

    protected function getValidModel(): Order
    {
        // does not make so much sense because the method `getValidModel` is used for testing the `fromArray` method.
        // but the behaviour is tested :)
        return (new Order())
            ->fromArray([
                'external_code' => 'order-id',
                'uuid' => '123456',
                'state' => 'declined',
                'decline_reason' => 'risk_policy',
                'amount' => ResponseHelper::PHPUNIT_OBJECT,
                'unshipped_amount' => ResponseHelper::PHPUNIT_OBJECT,
                'duration' => 23,
                'created_at' => '2022-01-02 12:23:45',
                'delivery_address' => ResponseHelper::PHPUNIT_OBJECT,
                'debtor' => ResponseHelper::PHPUNIT_OBJECT,
                'invoices' => [ResponseHelper::PHPUNIT_OBJECT, ResponseHelper::PHPUNIT_OBJECT],
                'selected_payment_method' => 'bank_transfer',
                'payment_methods' => [ResponseHelper::PHPUNIT_OBJECT, ResponseHelper::PHPUNIT_OBJECT],
            ]);
    }
}
