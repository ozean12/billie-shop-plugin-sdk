<?php


namespace Billie\Sdk\Tests\Acceptance\Model\Request;


use Billie\Sdk\Model\Request\CreateSessionRequestModel;
use PHPUnit\Framework\TestCase;

class CreateSessionRequestModelTest extends TestCase
{

    public function testToArray()
    {
        $data = (new CreateSessionRequestModel())
            ->setMerchantCustomerId('123456789')
            ->toArray();

        self::assertEquals('123456789', $data['merchant_customer_id']);
    }
}