<?php


namespace Billie\Sdk\Tests\Acceptance\Model\Request;


use Billie\Sdk\Model\Request\OrderRequestModel;
use Billie\Sdk\Tests\Acceptance\Model\AbstractModelTestCase;

class OrderRequestModelTest extends AbstractModelTestCase
{

    public function testToArray()
    {
        $data = new OrderRequestModel('uuid');
        self::assertCount(0, $data->toArray());
        self::assertEquals('uuid', $data->getId());

        $data->setId('uuid-2');
        self::assertCount(0, $data->toArray());
        self::assertEquals('uuid-2', $data->getId());
    }

}