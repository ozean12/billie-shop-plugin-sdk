<?php

namespace Billie\Sdk\Tests\Functional\Service\Request;

use Billie\Sdk\Model\Request\CreateSessionRequestModel;
use Billie\Sdk\Model\Response\CreateSessionResponseModel;
use Billie\Sdk\Service\Request\CreateSessionRequest;
use Billie\Sdk\Tests\Helper\BillieClientHelper;
use PHPUnit\Framework\TestCase;

class CreateCheckoutSessionTest extends TestCase
{

    public function testRetrieveOrderWithValidAttributes()
    {
        $requestService = new CreateSessionRequest(BillieClientHelper::getClient());

        $responseModel = $requestService->execute(
            (new CreateSessionRequestModel())
                ->setMerchantCustomerId('test-merchant-id')
        );

        self::assertInstanceOf(CreateSessionResponseModel::class, $responseModel);
        self::assertInternalType('string', $responseModel->getCheckoutSessionId());

    }
}