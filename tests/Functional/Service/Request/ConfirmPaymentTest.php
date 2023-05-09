<?php

declare(strict_types=1);

namespace Billie\Sdk\Tests\Functional\Service\Request;

use Billie\Sdk\Model\Order;
use Billie\Sdk\Model\Request\ConfirmPaymentRequestModel;
use Billie\Sdk\Model\Request\ShipOrderRequestModel;
use Billie\Sdk\Service\Request\ConfirmPaymentRequest;
use Billie\Sdk\Service\Request\CreateOrderRequest;
use Billie\Sdk\Service\Request\ShipOrderRequest;
use Billie\Sdk\Tests\AbstractTestCase;
use Billie\Sdk\Tests\Helper\BillieClientHelper;
use Billie\Sdk\Tests\Helper\OrderHelper;

class ConfirmPaymentTest extends AbstractTestCase
{
    private Order $createdOrderModel;

    protected function setUp(): void
    {
        $this->createdOrderModel = (new CreateOrderRequest(BillieClientHelper::getClient()))
            ->execute(OrderHelper::createValidOrderModel());

        (new ShipOrderRequest(BillieClientHelper::getClient()))
            ->execute(
                (new ShipOrderRequestModel($this->createdOrderModel->getUuid()))
                    ->setInvoiceNumber(uniqid('invoice-number', false))
                    ->setInvoiceUrl('https://domain.com/invoice.pdf')
            );
    }

    public function testConfirm(): void
    {
        $requestService = new ConfirmPaymentRequest(BillieClientHelper::getClient());
        $response = $requestService->execute(
            (new ConfirmPaymentRequestModel($this->createdOrderModel->getUuid()))
                ->setPaidAmount($this->createdOrderModel->getAmount()->getGross())
        );
        static::assertTrue($response);
    }
}
