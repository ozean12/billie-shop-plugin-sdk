<?php

declare(strict_types=1);

namespace Billie\Sdk\Tests\Acceptance\Model\Request;

use Billie\Sdk\Model\Request\PauseOrderDunningProcessRequestModel;
use Billie\Sdk\Tests\Acceptance\Model\AbstractModelTestCase;

class PauseOrderDunningProcessRequestModelTest extends AbstractModelTestCase
{
    public function testToArray(): void
    {
        $data = (new PauseOrderDunningProcessRequestModel('uuid'))
            ->setNumberOfDays(30)
            ->toArray();

        static::assertCount(1, $data); // uuid should not be returned
        static::assertEquals(30, $data['number_of_days']);
    }
}
