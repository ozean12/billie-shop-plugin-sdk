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
use Billie\Sdk\Model\Debtor;
use Billie\Sdk\Model\Request\CheckoutSessionConfirmRequestModel;
use Billie\Sdk\Tests\Acceptance\Model\AbstractModelTestCase;

class CheckoutSessionConfirmRequestModelTest extends AbstractModelTestCase
{
    public function testToArray(): void
    {
        $data = (new CheckoutSessionConfirmRequestModel())
            ->setSessionUuid('session-uuid')
            ->setAmount($this->createMock(Amount::class))
            ->setDebtor($this->createMock(Debtor::class))
            ->setDeliveryAddress($this->createMock(Address::class))
            ->setDuration(12)
            ->setExternalCode('test-order-id')
            ->toArray();

        static::assertCount(5, $data); // session-uuid should not be in the data array
        static::assertIsArray($data['amount']);
        static::assertIsArray($data['debtor']);
        static::assertIsArray($data['delivery_address']);
        static::assertEquals('test-order-id', $data['external_code']);
    }
}
