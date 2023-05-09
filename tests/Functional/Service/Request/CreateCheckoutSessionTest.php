<?php

declare(strict_types=1);

namespace Billie\Sdk\Tests\Functional\Service\Request;

use Billie\Sdk\Model\Request\CreateSessionRequestModel;
use Billie\Sdk\Model\Response\CreateSessionResponseModel;
use Billie\Sdk\Service\Request\CreateSessionRequest;
use Billie\Sdk\Tests\Helper\BillieClientHelper;
use PHPUnit\Framework\TestCase;

class CreateCheckoutSessionTest extends TestCase
{
    public function testRetrieveOrderWithValidAttributes(): void
    {
        $requestService = new CreateSessionRequest(BillieClientHelper::getClient());

        $responseModel = $requestService->execute(
            (new CreateSessionRequestModel())
                ->setMerchantCustomerId('test-merchant-id')
        );

        static::assertInstanceOf(CreateSessionResponseModel::class, $responseModel);
        static::assertIsString($responseModel->getCheckoutSessionId());
    }
}
