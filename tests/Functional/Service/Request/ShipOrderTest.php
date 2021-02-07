<?php


namespace Billie\Sdk\Tests\Functional\Service\Request;


use Billie\Sdk\Model\Invoice;
use Billie\Sdk\Model\Order;
use Billie\Sdk\Model\Request\ShipOrderRequestModel;
use Billie\Sdk\Service\Request\CreateOrderRequest;
use Billie\Sdk\Service\Request\ShipOrderRequest;
use Billie\Sdk\Tests\AbstractTestCase;
use Billie\Sdk\Tests\Helper\BillieClientHelper;
use Billie\Sdk\Tests\Helper\OrderHelper;

class ShipOrderTest extends AbstractTestCase
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

    public function testShip()
    {
        $invoiceNumber = uniqid('invoice-number-', true);
        $externalOrderNumber = uniqid('external-order-id', true);
        $requestService = new ShipOrderRequest(BillieClientHelper::getClient());
        $order = $requestService->execute(
            (new ShipOrderRequestModel($this->createdOrderModel->getUuid()))
                ->setInvoiceUrl('https://www.domain.com/invoice.pdf')
                ->setShippingDocumentUrl('https://www.domain.com/invoice.pdf')
                ->setExternalOrderId($externalOrderNumber)
                ->setInvoiceNumber($invoiceNumber)
        );

        self::assertEquals(Order::STATE_SHIPPED, $order->getState());
        self::assertInstanceOf(Invoice::class, $order->getInvoice());
        self::assertEquals($invoiceNumber, $order->getInvoice()->getNumber());
        self::assertEquals($this->createdOrderModel->getAmount()->getGross(), $order->getInvoice()->getOutstandingAmount());
        self::assertNotNull($order->getShippedAt());
    }

}