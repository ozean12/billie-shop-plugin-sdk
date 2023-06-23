<?php
/*
 * Copyright (c) Billie GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Billie\Sdk\Tests\Functional\Service\Request\Order;

use Billie\Sdk\Model\Order;
use Billie\Sdk\Model\Request\OrderRequestModel;
use Billie\Sdk\Service\Request\Order\CancelOrderRequest;
use Billie\Sdk\Service\Request\Order\CreateOrderRequest;
use Billie\Sdk\Tests\Functional\Service\Request\AbstractRequestServiceTestCase;
use Billie\Sdk\Tests\Helper\BillieClientHelper;
use Billie\Sdk\Tests\Helper\OrderHelper;

class CancelOrderTest extends AbstractRequestServiceTestCase
{
    protected static bool $serviceMustThrowExceptionOnEmptyResponse = false;

    private Order $createdOrderModel;

    public function testCancel(): void
    {
        $this->createdOrderModel = (new CreateOrderRequest(BillieClientHelper::getClient()))
            ->execute(OrderHelper::createValidOrderModel());

        $requestService = new CancelOrderRequest(BillieClientHelper::getClient());
        $success = $requestService->execute(new OrderRequestModel($this->createdOrderModel->getUuid()));

        static::assertTrue($success);
    }

    protected function getRequestServiceClass(): string
    {
        return CancelOrderRequest::class;
    }
}
