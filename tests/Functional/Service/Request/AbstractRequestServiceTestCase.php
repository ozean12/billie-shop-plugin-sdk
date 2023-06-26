<?php
/*
 * Copyright (c) Billie GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Billie\Sdk\Tests\Functional\Service\Request;

use Billie\Sdk\Exception\InvalidResponseException;
use Billie\Sdk\Exception\NotFoundException;
use Billie\Sdk\HttpClient\BillieClient;
use Billie\Sdk\Service\Request\AbstractRequest;
use Billie\Sdk\Tests\Functional\Mock\Model\EmptyRequestModel;
use PHPUnit\Framework\TestCase;
use RuntimeException;

abstract class AbstractRequestServiceTestCase extends TestCase
{
    protected static bool $serviceMustThrowExceptionOnEmptyResponse = true;

    public function testExceptionThrowOnInvalidResponse(): void
    {
        $serviceClass = $this->getRequestServiceClass();

        if (!is_subclass_of($serviceClass, AbstractRequest::class)) {
            throw new RuntimeException(sprintf('%s is not a subclass of %s', $serviceClass, AbstractRequest::class));
        }

        $clientMock = $this->createMock(BillieClient::class);
        $clientMock->method('request')->willReturn([]);

        if (static::$serviceMustThrowExceptionOnEmptyResponse) {
            $this->expectException(InvalidResponseException::class);
        }

        $requestModelMock = $this->createMock(EmptyRequestModel::class);
        $requestModelMock->method('toArray')->willReturn([]);

        $requestService = $this->getRequestServiceInstance($clientMock);
        $requestService->setCacheFlag(false);

        $response = $requestService->execute($requestModelMock);

        $this->assertIsBool($response, 'If no exception should be thrown be request service, the request service should return a boolean');
    }

    abstract protected function getRequestServiceClass(): string;

    protected function getRequestServiceInstance(BillieClient $client): AbstractRequest  // @phpstan-ignore-line
    {
        $serviceClass = $this->getRequestServiceClass();
        return new $serviceClass($client); // @phpstan-ignore-line
    }

    protected function createClientNotFoundExceptionMock(): BillieClient
    {
        $mock = $this->createMock(BillieClient::class);
        $mock->method('request')->willThrowException(new NotFoundException('', 404));

        return $mock;
    }
}
