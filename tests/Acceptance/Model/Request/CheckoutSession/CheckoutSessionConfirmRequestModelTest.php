<?php
/*
 * Copyright (c) Billie GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Billie\Sdk\Tests\Acceptance\Model\Request\CheckoutSession;

use Billie\Sdk\Model\Address;
use Billie\Sdk\Model\Amount;
use Billie\Sdk\Model\Request\CheckoutSession\CheckoutSessionConfirmRequestModel;
use Billie\Sdk\Model\Request\CheckoutSession\Confirm\Debtor;
use Billie\Sdk\Tests\Acceptance\Model\AbstractModelTestCase;

class CheckoutSessionConfirmRequestModelTest extends AbstractModelTestCase
{
    public function testToArray(): void
    {
        $data = $this->getValidModel()->toArray();

        static::assertCount(5, $data); // session-uuid should not be in the data array
        static::assertIsArray($data['amount'] ?? null);
        static::assertIsArray($data['debtor'] ?? null);
        static::assertIsArray($data['delivery_address'] ?? null);
        static::assertEquals('test-order-id', $data['external_code'] ?? null);
    }

    protected function getValidModel(): CheckoutSessionConfirmRequestModel
    {
        return (new CheckoutSessionConfirmRequestModel())
            ->setSessionUuid('session-uuid')
            ->setAmount($this->createModelMock(Amount::class))
            ->setDebtor($this->createModelMock(Debtor::class))
            ->setDeliveryAddress($this->createModelMock(Address::class))
            ->setDuration(12)
            ->setExternalCode('test-order-id')
        ;
    }
}
