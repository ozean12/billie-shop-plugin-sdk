<?php


namespace Billie\Sdk\Tests\Acceptance\Model\Request;


use Billie\Sdk\Model\Request\PauseOrderDunningProcessRequestModel;
use Billie\Sdk\Tests\Acceptance\Model\AbstractModelTestCase;

class PauseOrderDunningProcessRequestModelTest extends AbstractModelTestCase
{

    public function testToArray()
    {
        $data = (new PauseOrderDunningProcessRequestModel('uuid'))
            ->setNumberOfDays(30)
            ->toArray();

        self::assertCount(1, $data); // uuid should not be returned
        self::assertEquals(30, $data['number_of_days']);
    }

}