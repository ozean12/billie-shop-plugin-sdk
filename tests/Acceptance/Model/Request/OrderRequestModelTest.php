<?php

declare(strict_types=1);

namespace Billie\Sdk\Tests\Acceptance\Model\Request;

use Billie\Sdk\Model\Request\OrderRequestModel;
use Billie\Sdk\Tests\Acceptance\Model\AbstractModelTestCase;

class OrderRequestModelTest extends AbstractModelTestCase
{
    public function testToArray(): void
    {
        $data = new OrderRequestModel('uuid');
        static::assertCount(0, $data->toArray());
        static::assertEquals('uuid', $data->getId());

        $data->setId('uuid-2');
        static::assertCount(0, $data->toArray());
        static::assertEquals('uuid-2', $data->getId());
    }
}
