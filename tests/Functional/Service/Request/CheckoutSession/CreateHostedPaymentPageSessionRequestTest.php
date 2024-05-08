<?php
/*
 * Copyright (c) Billie GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Billie\Sdk\Tests\Functional\Service\Request\CheckoutSession;

use Billie\Sdk\Model\AddressWithAddition;
use Billie\Sdk\Model\Amount;
use Billie\Sdk\Model\LineItem;
use Billie\Sdk\Model\Person;
use Billie\Sdk\Model\Request\CheckoutSession\CreateHostedPaymentPageSessionRequestModel;
use Billie\Sdk\Model\Request\CheckoutSession\CreateSessionRequestModel;
use Billie\Sdk\Model\Request\CheckoutSession\HostedPaymentPage\DebtorCompany;
use Billie\Sdk\Model\Request\CheckoutSession\HostedPaymentPage\MerchantUrls;
use Billie\Sdk\Model\Response\CreateHostedPaymentPageSessionResponseModel;
use Billie\Sdk\Service\Request\CheckoutSession\CreateHostedPaymentPageSessionRequest;
use Billie\Sdk\Service\Request\CheckoutSession\CreateSessionRequest;
use Billie\Sdk\Tests\Functional\Service\Request\AbstractRequestServiceTestCase;
use Billie\Sdk\Tests\Helper\BillieClientHelper;
use DateTime;

class CreateHostedPaymentPageSessionRequestTest extends AbstractRequestServiceTestCase
{
    public function testRetrieveOrderWithValidAttributes(): void
    {
        $requestService = new CreateHostedPaymentPageSessionRequest(BillieClientHelper::getClient());

        $responseModel = $requestService->execute($this->getValidRequestModel());

        static::assertInstanceOf(CreateHostedPaymentPageSessionResponseModel::class, $responseModel);
        static::assertIsString($responseModel->getSessionId());
        static::assertIsString($responseModel->getHppUrl());
        static::assertInstanceOf(DateTime::class, $responseModel->getExpiresAt());
    }

    public function getValidEmptyRequestModelClass(): string
    {
        return CreateSessionRequestModel::class;
    }

    protected function getRequestServiceClass(): string
    {
        return CreateSessionRequest::class;
    }

    private function getValidRequestModel(): CreateHostedPaymentPageSessionRequestModel
    {
        return (new CreateHostedPaymentPageSessionRequestModel())
            ->setChannel('hpp_telesales')
            ->setAmount(
                (new Amount())
                    ->setGross(238)
                    ->setNet(200)
            )
            ->setDuration(30)
            ->setDebtorCompany(
                (new DebtorCompany())
                    ->setMerchantCustomerId('test-123')
                    ->setName('Billie GmbH')
                    ->setLegalForm('GMBH')
                    ->setCompanyAddress(
                        (new AddressWithAddition())
                            ->setStreet('Charlottenstr.')
                            ->setHouseNumber('4')
                            ->setPostalCode('10969')
                            ->setCity('Berlin')
                            ->setCountryCode('DE')
                    )
            )
            ->setDebtorPerson(
                (new Person())
                    ->setMail('max.mustermann@test.local')
                    ->setSalutation('m')
                    ->setPhone('+4930120111111')
            )->addLineItem(
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
                            ->setGross(119)
                            ->setNet(19.00)
                    )
            )->setMerchantUrls(
                (new MerchantUrls())
                    ->setAcceptUrl('https://shop.internal/success')
                    ->setDeclineUrl('https://shop.internal/fail')
            );
    }
}
