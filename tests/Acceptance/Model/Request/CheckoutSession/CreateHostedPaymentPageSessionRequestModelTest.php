<?php
/*
 * Copyright (c) Billie GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Billie\Sdk\Tests\Acceptance\Model\Request\CheckoutSession;

use Billie\Sdk\Model\AbstractModel;
use Billie\Sdk\Model\AddressWithAddition;
use Billie\Sdk\Model\Amount;
use Billie\Sdk\Model\LineItem;
use Billie\Sdk\Model\Person;
use Billie\Sdk\Model\Request\CheckoutSession\CreateHostedPaymentPageSessionRequestModel;
use Billie\Sdk\Model\Request\CheckoutSession\HostedPaymentPage\DebtorCompany;
use Billie\Sdk\Model\Request\CheckoutSession\HostedPaymentPage\MerchantUrls;
use Billie\Sdk\Tests\Acceptance\Model\AbstractModelTestCase;

class CreateHostedPaymentPageSessionRequestModelTest extends AbstractModelTestCase
{
    public function testToArray(): void
    {
        $model = $this->getValidModel();
        $data = $model->toArray();

        self::assertArrayHasKey('channel', $data);
        self::assertEquals('hpp_ecommerce', $data['channel']);
        self::assertArrayHasKey('amount', $data);
        self::assertArrayHasKey('comment', $data);
        self::assertEquals('test-comment', $data['comment']);
        self::assertArrayHasKey('duration', $data);
        self::assertEquals(12, $data['duration']);
        self::assertArrayHasKey('order_id', $data);
        self::assertEquals('test-order-id', $data['order_id']);
        self::assertArrayHasKey('delivery_address', $data);
        self::assertArrayHasKey('billing_address', $data);
        self::assertArrayHasKey('debtor_company', $data);
        self::assertArrayHasKey('debtor_person', $data);
        self::assertArrayHasKey('line_items', $data);
        self::assertCount(2, $data['line_items']);
        self::assertArrayHasKey('merchant_urls', $data);
    }

    public function testMinimumModel(): void
    {
        $model = (new CreateHostedPaymentPageSessionRequestModel())
            ->setChannel('hpp_ecommerce')
            ->setAmount($this->createModelMock(Amount::class))
            ->setDuration(12)
            ->setDebtorCompany($this->createModelMock(DebtorCompany::class))
            ->setDebtorPerson($this->createModelMock(Person::class))
            ->setLineItems([$this->createModelMock(LineItem::class), $this->createModelMock(LineItem::class)]);

        $data = $model->toArray();
        self::assertArrayHasKey('channel', $data);
        self::assertEquals('hpp_ecommerce', $data['channel']);
        self::assertArrayHasKey('amount', $data);
        self::assertArrayHasKey('duration', $data);
        self::assertEquals(12, $data['duration']);
        self::assertArrayHasKey('debtor_company', $data);
        self::assertArrayHasKey('debtor_person', $data);
        self::assertArrayHasKey('line_items', $data);
    }

    protected function getValidModel(): AbstractModel
    {
        return (new CreateHostedPaymentPageSessionRequestModel())
            ->setChannel('hpp_ecommerce')
            ->setAmount($this->createModelMock(Amount::class))
            ->setComment('test-comment')
            ->setDuration(12)
            ->setOrderId('test-order-id')
            ->setDeliveryAddress($this->createModelMock(AddressWithAddition::class))
            ->setBillingAddress($this->createModelMock(AddressWithAddition::class))
            ->setDebtorCompany($this->createModelMock(DebtorCompany::class))
            ->setDebtorPerson($this->createModelMock(Person::class))
            ->setLineItems([$this->createModelMock(LineItem::class), $this->createModelMock(LineItem::class)])
            ->setMerchantUrls($this->createModelMock(MerchantUrls::class));
    }
}
