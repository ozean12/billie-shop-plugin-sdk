<?php

namespace Billie\Sdk\Tests\Functional\Service\Request;

use Billie\Sdk\Model\Request\GetLegalFormsRequestModel;
use Billie\Sdk\Model\Response\GetLegalFormsResponseModel;
use Billie\Sdk\Service\Request\GetLegalFormsRequest;
use Billie\Sdk\Tests\Helper\BillieClientHelper;
use PHPUnit\Framework\TestCase;

class GetLegalFormsTest extends TestCase
{

    public function testRetrieveOrderWithValidAttributes()
    {
        $requestService = new GetLegalFormsRequest(BillieClientHelper::getClient());

        $responseModel = $requestService->execute(new GetLegalFormsRequestModel());

        self::assertInstanceOf(GetLegalFormsResponseModel::class, $responseModel);
        self::assertInternalType('array', $responseModel->getItems());

        self::assertEquals(10001, $responseModel->getItems()[0]->getCode());
        self::assertEquals('GmbH (Gesellschaft mit beschränkter Haftung)', $responseModel->getItems()[0]->getName());
        self::assertEquals('HR-NR', $responseModel->getItems()[0]->getRequiredField());
        self::assertEquals(1, $responseModel->getItems()[0]->isRequired());

    }
}