<?php
/*
 * Copyright (c) Billie GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Billie\Sdk\Tests\Functional\Service\Request\Auth;

use Billie\Sdk\Model\Request\Auth\ValidateTokenRequestModel;
use Billie\Sdk\Model\Response\Auth\ValidateTokenResponse;
use Billie\Sdk\Service\Request\Auth\ValidateTokenRequest;
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
