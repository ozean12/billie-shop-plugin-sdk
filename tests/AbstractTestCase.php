<?php

namespace Billie\Sdk\Tests;

use PHPUnit\Framework\TestCase;

abstract class AbstractTestCase extends TestCase
{

    protected function compareArrays($expectedArray, $actualArray)
    {
        self::assertInternalType('array', $actualArray);
        if (is_array($actualArray)) {
            // we will only continue testing, if it is a array.

            foreach ($expectedArray as $expectedKey => $expectedValue) {
                if ($expectedKey === 'debtorUuid') {
                    // TODO: currently the api will not return the debtor_uuid on order-create
                    // seems to be a bug, and has been already reported.
                    continue;
                }
                self::assertArrayHasKey($expectedKey, $actualArray);
                if (is_array($expectedValue)) {
                    $this->compareArrays($expectedValue, $actualArray[$expectedKey]);
                } else if($expectedValue instanceof \DateTime) {
                    // TODO add PHP 8.0 support (self::assertEqualsWithDelta)
                    self::assertEquals($expectedValue, $actualArray[$expectedKey], null, 10);
                } else {
                    self::assertEquals($expectedValue, $actualArray[$expectedKey]);
                }
            }
        }
    }

}