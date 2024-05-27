<?php
/*
 * Copyright (c) Billie GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Billie\Sdk\Tests\Functional\Service\Request\Auth;

use Billie\Sdk\Exception\NotAllowedException;
use Billie\Sdk\Model\Request\Auth\RevokeTokenRequestModel;
use Billie\Sdk\Model\Request\Auth\ValidateTokenRequestModel;
use Billie\Sdk\Service\Request\Auth\RevokeTokenRequest;
use Billie\Sdk\Service\Request\Auth\ValidateTokenRequest;
use Billie\Sdk\Tests\Helper\BillieClientHelper;
use Billie\Sdk\Util\BillieClientFactory;
use PHPUnit\Framework\TestCase;

class RevokeTokenTest extends TestCase
{
    protected function tearDown(): void
    {
        BillieClientFactory::resetInstances(); // we need to reset the instances to make sure other tests will not use the revoked token
    }

    public function testRevoke(): void
    {
        $client = BillieClientHelper::getClient();
        $revokeService = new RevokeTokenRequest($client);
        $responseModel = $revokeService->execute(new RevokeTokenRequestModel());

        static::assertTrue($responseModel);

        $this->expectException(NotAllowedException::class);
        (new ValidateTokenRequest($client))->execute(new ValidateTokenRequestModel());
    }

    protected function getRequestServiceClass(): string
    {
        return ValidateTokenRequest::class;
    }
}
