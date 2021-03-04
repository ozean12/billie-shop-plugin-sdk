<?php


namespace Billie\Sdk\Tests\Acceptance\Model\Request;


use Billie\Sdk\Model\Request\ConfirmPaymentRequestModel;
use Billie\Sdk\Tests\Acceptance\Model\AbstractModelTestCase;

class ConfirmPaymentRequestModelTest extends AbstractModelTestCase
{
    public function testToArray()
    {
        $data = (new ConfirmPaymentRequestModel('uuid'))
            ->setPaidAmount(100.50)
            ->toArray();

        self::assertCount(1, $data); // session-uuid should not be in the data array
        self::assertEquals(100.50, $data['paid_amount']);
    }
}