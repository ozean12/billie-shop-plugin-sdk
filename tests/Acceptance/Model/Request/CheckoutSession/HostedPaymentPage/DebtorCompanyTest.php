<?php
/*
 * Copyright (c) Billie GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Billie\Sdk\Tests\Acceptance\Model\Request\CheckoutSession\HostedPaymentPage;

use Billie\Sdk\Model\AbstractModel;
use Billie\Sdk\Model\AddressWithAddition;
use Billie\Sdk\Model\Request\CheckoutSession\HostedPaymentPage\DebtorCompany;
use Billie\Sdk\Tests\Acceptance\Model\AbstractModelTestCase;

class DebtorCompanyTest extends AbstractModelTestCase
{
    public function testToArray(): void
    {
        $model = $this->getValidModel();
        $data = $model->toArray();

        self::assertCount(12, $data);
        self::assertArrayHasKey('name', $data);
        self::assertEquals('test-company', $data['name']);
        self::assertArrayHasKey('employees_number', $data);
        self::assertEquals(1, $data['employees_number']);
        self::assertArrayHasKey('industry_sector', $data);
        self::assertEquals('test-sector', $data['industry_sector']);
        self::assertArrayHasKey('subindustry_sector', $data);
        self::assertEquals('test-sub-sector', $data['subindustry_sector']);
        self::assertArrayHasKey('legal_form', $data);
        self::assertEquals('test-legal-form', $data['legal_form']);
        self::assertArrayHasKey('merchant_customer_id', $data);
        self::assertEquals('test-customer-id', $data['merchant_customer_id']);
        self::assertArrayHasKey('organisation_type', $data);
        self::assertEquals('test-organisation-type', $data['organisation_type']);
        self::assertArrayHasKey('registration_court', $data);
        self::assertEquals('test-registration-court', $data['registration_court']);
        self::assertArrayHasKey('registration_number', $data);
        self::assertEquals('test-registration-number', $data['registration_number']);
        self::assertArrayHasKey('tax_id', $data);
        self::assertEquals('test-tax-id', $data['tax_id']);
        self::assertArrayHasKey('tax_number', $data);
        self::assertEquals('test-tax-number', $data['tax_number']);
        self::assertArrayHasKey('established_customer', $data);
        self::assertTrue($data['established_customer']);

        self::assertArrayNotHasKey('billing_address', $data);
    }

    protected function getValidModel(): AbstractModel
    {
        return (new DebtorCompany())
            ->setName('test-company')
            ->setCompanyAddress($this->createModelMock(AddressWithAddition::class))
            ->setCountOfEmployees('1')
            ->setIndustrySector('test-sector')
            ->setSubIndustrySector('test-sub-sector')
            ->setLegalForm('test-legal-form')
            ->setMerchantCustomerId('test-customer-id')
            ->setOrganisationType('test-organisation-type')
            ->setRegistrationCourt('test-registration-court')
            ->setRegistrationNumber('test-registration-number')
            ->setTaxId('test-tax-id')
            ->setTaxNumber('test-tax-number')
            ->setEstablishedCustomer(true);
    }
}
