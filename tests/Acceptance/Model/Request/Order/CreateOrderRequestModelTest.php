<?php
/*
 * Copyright (c) Billie GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Billie\Sdk\Tests\Acceptance\Model\Request\Order;

use Billie\Sdk\Model\Address;
use Billie\Sdk\Model\Amount;
use Billie\Sdk\Model\LineItem;
use Billie\Sdk\Model\Person;
use Billie\Sdk\Model\Request\Order\CreateOrder\Debtor;
use Billie\Sdk\Model\Request\Order\CreateOrderRequestModel;
use Billie\Sdk\Tests\Acceptance\Model\AbstractModelTestCase;

class CreateOrderRequestModelTest extends AbstractModelTestCase
{
    public function testToArray(): void
    {
        $data = $this->getValidModel()->toArray();

        static::assertIsArray($data['amount'] ?? null);
        static::assertEquals(12, $data['duration'] ?? null);
        static::assertIsArray($data['debtor'] ?? null);
        static::assertIsArray($data['debtor_person']);
        static::assertEquals('test-comment', $data['comment'] ?? null);
        static::assertEquals('test-order-id', $data['external_code'] ?? null);
        static::assertIsArray($data['delivery_address'] ?? null);
        static::assertIsArray($data['line_items'] ?? null);
        static::assertCount(2, $data['line_items']);
    }

    protected function getValidModel(): CreateOrderRequestModel
    {
        return (new CreateOrderRequestModel())
            ->setAmount($this->createMock(Amount::class))
            ->setDuration(12)
            ->setDebtor($this->createMock(Debtor::class))
            ->setPerson($this->createMock(Person::class))
            ->setComment('test-comment')
            ->setExternalCode('test-order-id')
            ->setDeliveryAddress($this->createMock(Address::class))
            ->setLineItems([
                $this->createMock(LineItem::class),
                $this->createMock(LineItem::class),
            ]);
    }
}
