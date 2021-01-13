<?php

namespace Billie\Sdk\Tests\Functional\Service\Request;

use Billie\Sdk\Exception\UserNotAuthorizedException;
use Billie\Sdk\Model\Request\GetTokenRequestModel;
use Billie\Sdk\Model\Response\GetTokenResponseModel;
use Billie\Sdk\Service\Request\GetTokenRequest;
use Billie\Sdk\Tests\Helper\BillieClientHelper;
use DateTime;
use PHPUnit\Framework\TestCase;

class RequestTokenTest extends TestCase
{
    public function testRequestToken()
    {
        $tokenRequestService = new GetTokenRequest(true);

        $responseModel = $tokenRequestService->execute(
            (new GetTokenRequestModel())
                ->setClientId(BillieClientHelper::getClientId())
                ->setClientSecret(BillieClientHelper::getClientSecret())
        );

        self::assertInstanceOf(GetTokenResponseModel::class, $responseModel);
        self::assertEquals('Bearer', $responseModel->getTokenType());
        self::assertInstanceOf(DateTime::class, $responseModel->getExpires());
        self::assertNotNull($responseModel->getAccessToken());
    }

    public function testInvalid()
    {
        $tokenRequestService = new GetTokenRequest(true);

        $this->expectException(UserNotAuthorizedException::class);
        $tokenRequestService->execute(
            (new GetTokenRequestModel())
                ->setClientId('invalid')
                ->setClientSecret('invalid')
        );
    }
}