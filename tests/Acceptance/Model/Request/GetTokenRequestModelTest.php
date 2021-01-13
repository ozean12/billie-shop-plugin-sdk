<?php


namespace Billie\Sdk\Tests\Acceptance\Model\Request;


use Billie\Sdk\Model\Request\GetTokenRequestModel;
use PHPUnit\Framework\TestCase;

class GetTokenRequestModelTest extends TestCase
{

    public function testToArray()
    {
        $data = (new GetTokenRequestModel())
            ->setClientId('client-id')
            ->setClientSecret('client-secret')
            ->toArray();

        self::assertEquals('client_credentials', $data['grant_type']);
        self::assertEquals('client-id', $data['client_id']);
        self::assertEquals('client-secret', $data['client_secret']);
    }
}