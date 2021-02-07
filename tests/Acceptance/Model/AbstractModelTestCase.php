<?php


namespace Billie\Sdk\Tests\Acceptance\Model;


use PHPUnit\Framework\TestCase;

abstract class AbstractModelTestCase extends TestCase
{
    protected function createMock($originalClassName)
    {
        $mock = parent::createMock($originalClassName);
        if (strpos($originalClassName, 'Billie\Sdk\Model\\') === 0) {
            $mock->method('toArray')->willReturn([]);
        }
        return $mock;
    }
}