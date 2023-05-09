<?php

declare(strict_types=1);

namespace Billie\Sdk\Tests\Functional\Service\Request;

use Billie\Sdk\Model\Request\ValidateTokenRequestModel;
use Billie\Sdk\Model\Response\ValidateTokenResponse;
use Billie\Sdk\Service\Request\ValidateTokenRequest;
use Billie\Sdk\Tests\Helper\BillieClientHelper;
use PHPUnit\Framework\TestCase;

class ValidateTokenTest extends TestCase
{
    public function testValidate(): void
    {
        $validateTokenRequest = new ValidateTokenRequest(BillieClientHelper::getClient());
        $responseModel = $validateTokenRequest->execute(new ValidateTokenRequestModel());

        static::assertInstanceOf(ValidateTokenResponse::class, $responseModel);
        static::assertEquals(BillieClientHelper::getClientId(), $responseModel->getClientId());
        static::assertIsArray($responseModel->getScopes());
    }
}
