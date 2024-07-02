<?php
/*
 * Copyright (c) Billie GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Billie\Sdk\Tests\Acceptance\Model\Response\CheckoutSession;

use Billie\Sdk\Model\Address;
use Billie\Sdk\Model\Amount;
use Billie\Sdk\Model\Debtor;
use Billie\Sdk\Model\Response\CheckoutSession\GetCheckoutAuthorizationResponseModel;
use Billie\Sdk\Util\ResponseHelper;
use PHPUnit\Framework\TestCase;

class GetCheckoutAuthorizationResponseModelTest extends TestCase
{
    public function testFromArray(): void
    {
        $model = new GetCheckoutAuthorizationResponseModel([
            'state' => 'authorized',
            'decline_reason' => 'risk_scoring_failed',
            'amount' => ResponseHelper::PHPUNIT_OBJECT,
            'debtor' => [
                'name' => 'test-company',
                'company_address' => [
                    'address_house_number' => 123,
                    'address_street' => 'test-street',
                    'address_city' => 'test-city',
                    'address_postal_code' => 12345,
                    'address_country' => 'test-country',
                ],
            ],
        ]);

        static::assertEquals('authorized', $model->getState());
        static::assertEquals('risk_scoring_failed', $model->getDeclineReason());
        static::assertInstanceOf(Amount::class, $model->getAmount());
        static::assertInstanceOf(Debtor::class, $model->getDebtor());
        static::assertEquals('test-company', $model->getDebtor()->getName());
        static::assertInstanceOf(Address::class, $model->getDebtor()->getCompanyAddress());
        static::assertEquals(123, $model->getDebtor()->getCompanyAddress()->getHouseNumber());
        static::assertEquals('test-street', $model->getDebtor()->getCompanyAddress()->getStreet());
        static::assertEquals(12345, $model->getDebtor()->getCompanyAddress()->getPostalCode());
        static::assertEquals('test-city', $model->getDebtor()->getCompanyAddress()->getCity());
        static::assertEquals('test-country', $model->getDebtor()->getCompanyAddress()->getCountryCode());
    }

    public function testFromArrayWithNoReason(): void
    {
        $model = new GetCheckoutAuthorizationResponseModel([
            'state' => 'authorized',
            'decline_reason' => null,
            'amount' => ResponseHelper::PHPUNIT_OBJECT,
            'debtor' => [
                'name' => 'test-company',
                'company_address' => [
                    'address_house_number' => 123,
                    'address_street' => 'test-street',
                    'address_city' => 'test-city',
                    'address_postal_code' => 12345,
                    'address_country' => 'test-country',
                ],
            ],
        ]);

        static::assertNull($model->getDeclineReason());
    }
}
