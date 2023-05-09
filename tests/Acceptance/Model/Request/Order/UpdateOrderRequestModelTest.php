<?php
/*
 * Copyright (c) Billie GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Billie\Sdk\Tests\Acceptance\Model\Request\Order;

use Billie\Sdk\Model\Amount;
use Billie\Sdk\Model\Request\Order\UpdateOrderRequestModel;
use Billie\Sdk\Tests\Acceptance\Model\AbstractModelTestCase;

class UpdateOrderRequestModelTest extends AbstractModelTestCase
{
    public function testToArray(): void
    {
        $data = (new UpdateOrderRequestModel('uuid'))
            ->setExternalCode('order-id')
            ->setAmount($this->createMock(Amount::class))
            ->toArray();

        static::assertCount(2, $data); // uuid should not be returned
        static::assertEquals('order-id', $data['external_code']);
        static::assertIsArray($data['amount']);
    }
}
