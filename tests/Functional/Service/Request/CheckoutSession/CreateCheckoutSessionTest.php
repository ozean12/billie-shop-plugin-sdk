<?php
/*
 * Copyright (c) Billie GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Billie\Sdk\Tests\Functional\Service\Request\CheckoutSession;

use Billie\Sdk\Model\Request\CheckoutSession\CreateSessionRequestModel;
use Billie\Sdk\Model\Response\CreateSessionResponseModel;
use Billie\Sdk\Service\Request\CheckoutSession\CreateSessionRequest;
use Billie\Sdk\Tests\Functional\Service\Request\AbstractRequestServiceTestCase;
use Billie\Sdk\Tests\Helper\BillieClientHelper;

class CreateCheckoutSessionTest extends AbstractRequestServiceTestCase
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

    public function getValidEmptyRequestModelClass(): string
    {
        return CreateSessionRequestModel::class;
    }

    protected function getRequestServiceClass(): string
    {
        return CreateSessionRequest::class;
    }
}
