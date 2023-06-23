<?php
/*
 * Copyright (c) Billie GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Billie\Sdk\Tests\Functional\Service\Request\Auth;

use Billie\Sdk\Exception\UserNotAuthorizedException;
use Billie\Sdk\HttpClient\BillieClient;
use Billie\Sdk\Model\Request\Auth\GetTokenRequestModel;
use Billie\Sdk\Model\Response\Auth\GetTokenResponseModel;
use Billie\Sdk\Service\Request\AbstractRequest;
use Billie\Sdk\Service\Request\Auth\GetTokenRequest;
use Billie\Sdk\Tests\Functional\Service\Request\AbstractRequestServiceTestCase;
use Billie\Sdk\Tests\Helper\BillieClientHelper;
use DateTime;

class RequestTokenTest extends AbstractRequestServiceTestCase
{
    public function testRequestToken(): void
    {
        $tokenRequestService = new GetTokenRequest(true);

        $responseModel = $tokenRequestService->execute(
            (new GetTokenRequestModel())
                ->setClientId(BillieClientHelper::getClientId())
                ->setClientSecret(BillieClientHelper::getClientSecret())
        );

        static::assertInstanceOf(GetTokenResponseModel::class, $responseModel);
        static::assertEquals('Bearer', $responseModel->getTokenType());
        static::assertInstanceOf(DateTime::class, $responseModel->getExpires());
        static::assertNotNull($responseModel->getAccessToken());
    }

    public function testInvalid(): void
    {
        $tokenRequestService = new GetTokenRequest(true);

        $this->expectException(UserNotAuthorizedException::class);
        $tokenRequestService->execute(
            (new GetTokenRequestModel())
                ->setClientId('invalid')
                ->setClientSecret('invalid')
        );
    }

    protected function getRequestServiceClass(): string
    {
        return GetTokenRequest::class;
    }

    /**
     * @phpstan-ignore-next-line
     */
    protected function getRequestServiceInstance(BillieClient $client): AbstractRequest
    {
        return (new GetTokenRequest())->setClient($client);
    }
}
