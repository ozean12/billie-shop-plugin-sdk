<?php

namespace Billie\Sdk\Tests\Functional\Service\Request;

use Billie\Sdk\Model\Request\ValidateTokenRequestModel;
use Billie\Sdk\Model\Response\ValidateTokenResponse;
use Billie\Sdk\Service\Request\ValidateTokenRequest;
use Billie\Sdk\Tests\Helper\BillieClientHelper;
use PHPUnit\Framework\TestCase;

class ValidateTokenTest extends TestCase
{
    public function testValidate()
    {
        $validateTokenRequest = new ValidateTokenRequest(BillieClientHelper::getClient());
        $responseModel = $validateTokenRequest->execute(new ValidateTokenRequestModel());

        self::assertInstanceOf(ValidateTokenResponse::class, $responseModel);
        self::assertEquals(BillieClientHelper::getClientId(), $responseModel->getClientId());
        self::assertInternalType('array', $responseModel->getScopes());
    }
}