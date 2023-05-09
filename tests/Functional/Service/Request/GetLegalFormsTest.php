<?php
/*
 * Copyright (c) Billie GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Billie\Sdk\Tests\Functional\Service\Request;

use Billie\Sdk\Model\Request\GetLegalFormsRequestModel;
use Billie\Sdk\Model\Response\GetLegalFormsResponseModel;
use Billie\Sdk\Service\Request\GetLegalFormsRequest;
use Billie\Sdk\Tests\Helper\BillieClientHelper;
use PHPUnit\Framework\TestCase;

class GetLegalFormsTest extends TestCase
{
    public function testRetrieveOrderWithValidAttributes(): void
    {
        $requestService = new GetLegalFormsRequest(BillieClientHelper::getClient());

        $responseModel = $requestService->execute(new GetLegalFormsRequestModel());

        static::assertInstanceOf(GetLegalFormsResponseModel::class, $responseModel);
        static::assertIsArray($responseModel->getItems());

        static::assertEquals(10001, $responseModel->getItems()[0]->getCode());
        static::assertEquals('GmbH (Gesellschaft mit beschränkter Haftung)', $responseModel->getItems()[0]->getName());
        static::assertEquals('HR-NR', $responseModel->getItems()[0]->getRequiredField());
        static::assertEquals(1, $responseModel->getItems()[0]->isRequired());
    }
}
