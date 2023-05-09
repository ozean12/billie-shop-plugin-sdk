<?php

declare(strict_types=1);

namespace Billie\Sdk\Tests;

use DateTime;
use PHPUnit\Framework\TestCase;

abstract class AbstractTestCase extends TestCase
{
    protected function compareArrays(array $expectedArray, array $actualArray): void
    {
        static::assertIsArray($actualArray);
        foreach ($expectedArray as $expectedKey => $expectedValue) {
            if ($expectedKey === 'debtorUuid') {
                // TODO: currently the api will not return the debtor_uuid on order-create
                // seems to be a bug, and has been already reported.
                continue;
            }

            static::assertArrayHasKey($expectedKey, $actualArray);
            if (is_array($expectedValue)) {
                $this->compareArrays($expectedValue, $actualArray[$expectedKey]);
            } elseif ($expectedValue instanceof DateTime) {
                static::assertEqualsWithDelta($expectedValue, $actualArray[$expectedKey], 10);
            } else {
                static::assertEquals($expectedValue, $actualArray[$expectedKey]);
            }
        }
    }
}
