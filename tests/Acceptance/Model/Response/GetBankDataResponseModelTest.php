<?php


namespace Billie\Sdk\Model\Response;

use Billie\Sdk\Tests\Acceptance\Model\AbstractModelTestCase;

class GetBankDataResponseModelTest extends AbstractModelTestCase
{

    public function testFromArray()
    {
        $responseModel = new GetBankDataResponseModel([
            'items' => [
                [
                    'BIC' => 'ABCDEF',
                    'Name' => 'Bank name 1'
                ],
                [
                    'BIC' => 'GHIJKL',
                    'Name' => 'Bank name 2'
                ]
            ]
        ]);

        self::assertInternalType('array', $responseModel->getItems());
        self::assertCount(2, $responseModel->getItems());

        self::assertEquals('Bank name 1', $responseModel->getBankName('ABCDEF'));
        self::assertEquals('Bank name 2', $responseModel->getBankName('GHIJKL'));
    }

}