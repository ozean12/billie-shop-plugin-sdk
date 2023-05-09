<?php
/*
 * Copyright (c) Billie GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Billie\Sdk\Tests\Functional\Service\Request\Invoice;

use Billie\Sdk\Exception\InvalidRequestException;
use Billie\Sdk\Model\Amount;
use Billie\Sdk\Model\Order;
use Billie\Sdk\Model\Request\Invoice\CreateInvoiceRequestModel;
use Billie\Sdk\Model\Response\CreateInvoiceResponseModel;
use Billie\Sdk\Service\Request\CreateOrderRequest;
use Billie\Sdk\Service\Request\Invoice\CreateInvoiceRequest;
use Billie\Sdk\Tests\Functional\Service\Request\AbstractOrderRequest;
use Billie\Sdk\Tests\Helper\BillieClientHelper;
use Billie\Sdk\Tests\Helper\OrderHelper;

class CreateInvoiceRequestTest extends AbstractOrderRequest
{
    private Order $createdOrderModel;

    protected function setUp(): void
    {
        $createModel = OrderHelper::createValidOrderModel($this->getName());
        $this->createdOrderModel = (new CreateOrderRequest(BillieClientHelper::getClient()))
            ->execute($createModel);

        $this->orderIds[] = $this->createdOrderModel->getUuid();

        // make sure test data has not changed
        static::assertCount(2, $createModel->getLineItems());
        static::assertEquals(200, $createModel->getAmount()->getGross());
        static::assertEquals(round(200 - 200 / 1.19, 2), round($createModel->getAmount()->getTax(), 2));
    }

    public function testCreateInvoiceWithFullAmount(): void
    {
        $requestService = new CreateInvoiceRequest(BillieClientHelper::getClient());

        $responseModel = $requestService->execute(
            (new CreateInvoiceRequestModel())
                ->setOrders([$this->createdOrderModel->getUuid()])
                ->setInvoiceNumber($this->createdOrderModel->getExternalCode() . '-invoice')
                ->setAmount(
                    (new Amount())
                        ->setGross(200)
                        ->setTaxRate(19.00)
                )
                ->setInvoiceUrl('https://invoice-url.com/path/to/invoice.pdf')
        );

        static::assertInstanceOf(CreateInvoiceResponseModel::class, $responseModel);
        static::assertIsString($responseModel->getUuid());
    }

    public function testCreateInvoiceWithThreeParts(): void
    {
        $requestService = new CreateInvoiceRequest(BillieClientHelper::getClient());

        $responseModel = $requestService->execute(
            (new CreateInvoiceRequestModel())
                ->setOrders([$this->createdOrderModel->getUuid()])
                ->setInvoiceNumber($this->createdOrderModel->getExternalCode() . '-invoice-1')
                ->setAmount(
                    (new Amount())
                        ->setGross(100)
                        ->setTaxRate(19.00)
                )
                ->setInvoiceUrl('https://invoice-url.com/path/to/invoice-1.pdf')
        );

        static::assertInstanceOf(CreateInvoiceResponseModel::class, $responseModel);
        static::assertIsString($responseModel->getUuid());

        $responseModel = $requestService->execute(
            (new CreateInvoiceRequestModel())
                ->setOrders([$this->createdOrderModel->getUuid()])
                ->setInvoiceNumber($this->createdOrderModel->getExternalCode() . '-invoice-2')
                ->setAmount(
                    (new Amount())
                        ->setGross(50)
                        ->setTaxRate(19.00)
                )
                ->setInvoiceUrl('https://invoice-url.com/path/to/invoice-2.pdf')
        );

        static::assertInstanceOf(CreateInvoiceResponseModel::class, $responseModel);
        static::assertIsString($responseModel->getUuid());

        $responseModel = $requestService->execute(
            (new CreateInvoiceRequestModel())
                ->setOrders([$this->createdOrderModel->getUuid()])
                ->setInvoiceNumber($this->createdOrderModel->getExternalCode() . '-invoice-3')
                ->setAmount(
                    (new Amount())
                        ->setGross(50)
                        ->setTaxRate(19.00)
                )
                ->setInvoiceUrl('https://invoice-url.com/path/to/invoice-3.pdf')
        );

        static::assertInstanceOf(CreateInvoiceResponseModel::class, $responseModel);
        static::assertIsString($responseModel->getUuid());
    }

    public function testCreateInvoiceWithInvalidAmount(): void
    {
        $requestService = new CreateInvoiceRequest(BillieClientHelper::getClient());

        $this->expectException(InvalidRequestException::class);
        $this->expectExceptionMessage('amount: Invoice amount should not exceed order unshipped amount');

        $requestService->execute(
            (new CreateInvoiceRequestModel())
                ->setOrders([$this->createdOrderModel->getUuid()])
                ->setInvoiceNumber($this->createdOrderModel->getExternalCode() . '-invoice-1')
                ->setAmount(
                    (new Amount())
                        ->setGross(999999)
                        ->setTaxRate(19.00)
                )
                ->setInvoiceUrl('https://invoice-url.com/path/to/invoice-1.pdf')
        );
    }
}
