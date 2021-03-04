<?php


namespace Billie\Sdk\Tests\Functional\Service\Request;


use Billie\Sdk\Model\Request\GetBankDataRequestModel;
use Billie\Sdk\Service\Request\GetBankDataRequest;
use PHPUnit\Framework\TestCase;

class GetBankDataRequestTest extends TestCase
{
    public function testExecute()
    {
        $requestService = new GetBankDataRequest();
        $responseModel = $requestService->execute(new GetBankDataRequestModel());

        self::assertInternalType('array', $responseModel->getItems());
        self::assertGreaterThan(30, $responseModel->getItems());

        // currently this values come from a static file from the sdk, so we can compare exact names.
        self::assertEquals('Aachener Bausparkasse', $responseModel->getBankName('AABSDE31XXX'));
        self::assertEquals('DB Privat- und Firmenkundenbank (Deutsche Bank PGK)', $responseModel->getBankName('DEUTDEDB803'));
    }
}