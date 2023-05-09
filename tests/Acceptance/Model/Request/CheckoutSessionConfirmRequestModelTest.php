<?php
/*
 * Copyright (c) Billie GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Billie\Sdk\Tests\Acceptance\Model\Request;

use Billie\Sdk\Model\Address;
use Billie\Sdk\Model\Amount;
use Billie\Sdk\Model\DebtorCompany;
use Billie\Sdk\Model\Request\CheckoutSessionConfirmRequestModel;
use Billie\Sdk\Tests\Acceptance\Model\AbstractModelTestCase;

class CheckoutSessionConfirmRequestModelTest extends AbstractModelTestCase
{
    public function testToArray(): void
    {
        $data = (new CheckoutSessionConfirmRequestModel())
            ->setSessionUuid('session-uuid')
            ->setAmount($this->createMock(Amount::class))
            ->setCompany($this->createMock(DebtorCompany::class))
            ->setDeliveryAddress($this->createMock(Address::class))
            ->setDuration(12)
            ->setOrderId('test-order-id')
            ->toArray();

        static::assertCount(5, $data); // session-uuid should not be in the data array
        static::assertIsArray($data['amount']);
        static::assertIsArray($data['debtor_company']);
        static::assertIsArray($data['delivery_address']);
        static::assertEquals(12, $data['duration']);
        static::assertEquals('test-order-id', $data['order_id']);
    }
}
