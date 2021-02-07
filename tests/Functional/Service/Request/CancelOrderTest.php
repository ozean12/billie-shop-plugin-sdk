<?php


namespace Billie\Sdk\Tests\Functional\Service\Request;


use Billie\Sdk\Model\Order;
use Billie\Sdk\Model\Request\OrderRequestModel;
use Billie\Sdk\Service\Request\CancelOrderRequest;
use Billie\Sdk\Service\Request\CreateOrderRequest;
use Billie\Sdk\Tests\Helper\BillieClientHelper;
use Billie\Sdk\Tests\Helper\OrderHelper;
use PHPUnit\Framework\TestCase;

class CancelOrderTest extends TestCase
{

    /**
     * @var Order
     */
    private $createdOrderModel;

    protected function setUp()
    {
        $this->createdOrderModel = (new CreateOrderRequest(BillieClientHelper::getClient()))
            ->execute(OrderHelper::createValidOrderModel());
    }

    public function testCancel()
    {
        $requestService = new CancelOrderRequest(BillieClientHelper::getClient());
        $success = $requestService->execute(new OrderRequestModel($this->createdOrderModel->getUuid()));

        self::assertTrue($success);
    }

}