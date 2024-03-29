<?php
/*
 * Copyright (c) Billie GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Billie\Sdk\Tests\Helper;

use Billie\Sdk\Model\Address;
use Billie\Sdk\Model\Amount;
use Billie\Sdk\Model\LineItem;
use Billie\Sdk\Model\Person;
use Billie\Sdk\Model\Request\Order\CreateOrder\Debtor;
use Billie\Sdk\Model\Request\Order\CreateOrderRequestModel;

class OrderHelper
{
    public static function createValidOrderModel(string $nameOfTest = 'unit-test'): CreateOrderRequestModel
    {
        $orderId = self::getUniqueOrderNumber($nameOfTest);
        $addressModel = (new Address())
            ->setStreet('Charlottenstr.')
            ->setHouseNumber('4')
            ->setPostalCode('10969')
            ->setCity('Berlin')
            ->setCountryCode('DE');

        return (new CreateOrderRequestModel())
            ->setExternalCode($orderId)
            ->setDebtor(
                (new Debtor())
                    ->setMerchantCustomerId('BILLIE-00000001-1')
                    ->setName('Billie GmbH')
                    ->setCompanyAddress($addressModel)
                    ->setLegalForm('10001')
                    ->setRegistrationNumber('1234567')
                    ->setRegistrationCourt('Amtsgericht Charlottenburg')
                    ->setBillingAddress($addressModel)
            )
            ->setPerson(
                (new Person())
                    ->setMail('max.mustermann@musterfirma.de')
                    ->setSalutation('m')
                    ->setPhone('+4930120111111')
            )
            ->setDeliveryAddress($addressModel)
            ->setAmount(
                (new Amount())
                    ->setGross(200.00)
                    ->setTaxRate(19.00)
            )
            ->setDuration(14)
            ->setComment('Test comment')
            ->addLineItem(
                (new LineItem())
                    ->setExternalId('product-id-1')
                    ->setTitle('product 1')
                    ->setDescription('description 1')
                    ->setCategory('category 1')
                    ->setBrand('brand 1')
                    ->setGtin('gtin 1')
                    ->setMpn('mpn 1')
                    ->setQuantity(2)
                    ->setAmount(
                        (new Amount())
                            ->setGross(50.00)
                            ->setTaxRate(19.00)
                    )
            )
            ->addLineItem(
                (new LineItem())
                    ->setExternalId('product-id-2')
                    ->setTitle('product 2')
                    ->setDescription('description 2')
                    ->setCategory('category 2')
                    ->setBrand('brand 2')
                    ->setGtin('gtin 2')
                    ->setMpn('mpn 2')
                    ->setQuantity(1)
                    ->setAmount(
                        (new Amount())
                            ->setGross(100.00)
                            ->setTaxRate(19.00)
                    )
            );
    }

    public static function getUniqueOrderNumber(string $nameOfTest): string
    {
        return $nameOfTest . '-' . microtime(true);
    }
}
