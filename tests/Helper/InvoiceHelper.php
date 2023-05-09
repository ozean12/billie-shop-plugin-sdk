<?php
/*
 * Copyright (c) Billie GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Billie\Sdk\Tests\Helper;

use Billie\Sdk\Model\Amount;
use Billie\Sdk\Model\Order;
use Billie\Sdk\Model\Request\Invoice\CreateInvoiceRequestModel;

class InvoiceHelper
{
    public static function createValidCreateInvoiceModel(Order $order): CreateInvoiceRequestModel
    {
        return (new CreateInvoiceRequestModel())
            ->setOrders([$order->getUuid()])
            ->setInvoiceNumber($order->getExternalCode() . '-invoice')
            ->setAmount(
                (new Amount())
                    ->setGross($order->getAmount()->getGross())
                    ->setNet($order->getAmount()->getNet())
            )
            ->setInvoiceUrl('https://invoice-url.com/path/to/invoice.pdf');
    }

    /**
     * @return CreateInvoiceRequestModel[]
     */
    public static function createValidTwoCreateInvoiceModels(Order $order, int $separatedAmount = 50): array
    {
        $taxRate = ($order->getAmount()->getTax() / $order->getAmount()->getNet()) * 100;

        return [
            (new CreateInvoiceRequestModel())
                ->setOrders([$order->getUuid()])
                ->setInvoiceNumber($order->getExternalCode() . '-invoice-1')
                ->setAmount(
                    (new Amount())
                        ->setGross($order->getAmount()->getGross() - $separatedAmount)
                        ->setTaxRate($taxRate)
                )
                ->setInvoiceUrl('https://invoice-url.com/path/to/invoice-1.pdf'),

            (new CreateInvoiceRequestModel())
                ->setOrders([$order->getUuid()])
                ->setInvoiceNumber($order->getExternalCode() . '-invoice-2')
                ->setAmount(
                    (new Amount())
                        ->setGross($separatedAmount)
                        ->setTaxRate($taxRate)
                )
                ->setInvoiceUrl('https://invoice-url.com/path/to/invoice-2.pdf'),
        ];
    }
}
