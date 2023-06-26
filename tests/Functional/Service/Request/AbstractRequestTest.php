<?php
/*
 * Copyright (c) Billie GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Billie\Sdk\Tests\Functional\Service\Request;

use Billie\Sdk\Exception\NotFoundException;
use Billie\Sdk\HttpClient\BillieClient;
use Billie\Sdk\Model\Request\AbstractRequestModel;
use Billie\Sdk\Model\Request\EntityRequestModelInterface;
use Billie\Sdk\Service\Request\AbstractRequest;
use Billie\Sdk\Tests\Functional\Mock\InvalidTestEntityNotFoundException;
use Billie\Sdk\Tests\Functional\Mock\TestEntityNotFoundException;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use RuntimeException;

class AbstractRequestTest extends TestCase
{
    public function testNotFoundBehaviourWithNoDefinedNotFoundException(): void
    {
        $expectedException = new NotFoundException('', 404);
        $client = $this->createMock(BillieClient::class);
        $client->method('request')->willThrowException($expectedException);

        $serviceInstance = new class($client) extends AbstractRequest {
            protected function getPath($requestModel): string
            {
                return '';
            }
        };

        // cause there is no other exception class defined in `getNotFoundExceptionClass` the exception should be the same, as defined.
        $this->expectException(NotFoundException::class);
        $this->expectExceptionObject($expectedException);

        $serviceInstance->execute(new class() extends AbstractRequestModel implements EntityRequestModelInterface {
            public function getBillieEntityId(): string
            {
                return '';
            }
        });
    }

    public function testNotFoundBehaviourWithDefinedNotFoundException(): void
    {
        $client = $this->createMock(BillieClient::class);
        $client->method('request')->willThrowException(new NotFoundException('', 404));

        $serviceInstance = new class($client) extends AbstractRequest {
            protected function getPath($requestModel): string
            {
                return '';
            }

            protected function getNotFoundExceptionClass(): ?string
            {
                return TestEntityNotFoundException::class;
            }
        };

        $this->expectException(TestEntityNotFoundException::class);
        $serviceInstance->execute(new class() extends AbstractRequestModel implements EntityRequestModelInterface {
            public function getBillieEntityId(): string
            {
                return '';
            }
        });
    }

    public function testNotFoundBehaviourWithDefinedInvalidFoundException(): void
    {
        $client = $this->createMock(BillieClient::class);
        $client->method('request')->willThrowException(new NotFoundException('', 404));

        $serviceInstance = new class($client) extends AbstractRequest {
            protected function getPath($requestModel): string
            {
                return '';
            }

            protected function getNotFoundExceptionClass(): ?string
            {
                return InvalidTestEntityNotFoundException::class;
            }
        };

        // RuntimeException should be thrown cause the InvalidTestEntityNotFoundException is not a child of EntityNotFoundException
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessageMatches('/.* needs to be an subclass of .*/');

        $serviceInstance->execute(new class() extends AbstractRequestModel implements EntityRequestModelInterface {
            public function getBillieEntityId(): string
            {
                return '';
            }
        });
    }

    public function testMissingClient(): void
    {
        $serviceInstance = new class() extends AbstractRequest {
            protected function getPath($requestModel): string
            {
                return '';
            }
        };

        // InvalidArgumentException should be thrown cause of missing billie client.
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessageMatches('/^please set a BillieClient instance to this request-service.*/');

        $serviceInstance->execute(new class() extends AbstractRequestModel {
        });
    }
}
