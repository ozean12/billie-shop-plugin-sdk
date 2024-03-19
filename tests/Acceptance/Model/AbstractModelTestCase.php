<?php
/*
 * Copyright (c) Billie GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Billie\Sdk\Tests\Acceptance\Model;

use BadMethodCallException;
use Billie\Sdk\Model\AbstractModel;
use Billie\Sdk\Model\Request\AbstractRequestModel;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

abstract class AbstractModelTestCase extends TestCase
{
    abstract public function testToArray(): void;

    /**
     * @depends testToArray
     */
    public function testFromArray(): void
    {
        $validModel = $this->getValidModel();
        if ($validModel instanceof AbstractRequestModel) {
            $this->expectException(BadMethodCallException::class);
            $validModel->fromArray([]);

            /** @noinspection PhpUnreachableStatementInspection */
            return;
        }

        $data = $validModel->toArray();

        $expectedArray = $data;
        ksort($expectedArray);

        $modelClass = get_class($validModel);
        $newArray = (new $modelClass())->fromArray($data)->toArray();
        ksort($newArray);

        static::assertEquals($expectedArray, $newArray);
    }

    /**
     * @psalm-template RealInstanceType of object
     * @psalm-param class-string<RealInstanceType> $originalClassName
     * @psalm-return MockObject&RealInstanceType
     */
    protected function createModelMock(string $originalClassName): MockObject
    {
        $mock = parent::createMock($originalClassName);
        if (strpos($originalClassName, 'Billie\Sdk\Model\\') === 0) {
            $mock->method('toArray')->willReturn([]);
            $mock->method('validateFields');
        }

        return $mock;
    }

    abstract protected function getValidModel(): AbstractModel;
}
