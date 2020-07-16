<?php

namespace Billie\Tests\acceptance;

use Billie\Command\CreateOrder;
use Billie\Command\PreapproveCreateOrder;
use Billie\Exception\InvalidCommandException;
use Billie\Exception\OrderDecline\DebtorAddressException;
use Billie\Exception\OrderDecline\DebtorLimitExceededException;
use Billie\Exception\OrderDecline\DebtorNotIdentifiedException;
use Billie\Exception\OrderDecline\RiskPolicyDeclinedException;
use Billie\HttpClient\BillieClient;
use Billie\Model\Address;
use Billie\Model\Amount;
use Billie\Model\Company;
use Billie\Model\Order;
use Billie\Model\Person;
use PHPUnit\Framework\TestCase;

/**
 * Class CreateOrderTest
 *
 * @package Billie\Tests\acceptance
 * @author Marcel Barten <github@m-barten.de>
 *
 */
final class PreapproveCreateOrderTest extends TestCase
{
    private $consumerKey = 'bfebbc05-d1f0-4e47-be21-c99e7fd2ffcc';
    private $consumerSecretKey = 'cv8hfihix4gso0koc0cgs8wosks4gwwwgo04cg00c4k4okggccg4wo8s88w8c4';

    public function testPreapproveCreateOrderWithValidAttributes()
    {
        // createOrderCommand
        $command = new PreapproveCreateOrder();

        $companyAddress = new Address();
        $companyAddress->street = 'Charlottenstr.';
        $companyAddress->houseNumber = '4';
        $companyAddress->postalCode = '10969';
        $companyAddress->city = 'Berlin';
        $companyAddress->countryCode = 'DE';
        $command->debtorCompany = new Company('BILLIE-00000001', 'Billie GmbH', $companyAddress);
        $command->debtorCompany->legalForm = '10001';
        $command->debtorCompany->registrationNumber = '1234567';
        $command->debtorCompany->registrationCourt = 'Amtsgericht Charlottenburg';


        $command->debtorPerson = new Person('max.mustermann@musterfirma.de');
        $command->debtorPerson->salution = 'm';
        $command->debtorPerson->phone = '+4930120111111';
        $command->deliveryAddress = $companyAddress; // or: new \Billie\Model\Address();
        $command->amount = new Amount(100, 'EUR', 19);

        $command->duration = 14;

        // Send Order To API
        $client = BillieClient::create($this->consumerKey, $this->consumerSecretKey,  true);
        $order = $client->preapproveCreateOrder($command);
        $this->assertNotEmpty($order->referenceId);
        $this->assertNotEmpty($order->referenceId);
        $this->assertEquals(Order::STATE_PREAPPROVED, $order->state);
    }
//
//    public function testCreateOrderWithDeliverAddressWithoutHousenumber()
//    {
//        // createOrderCommand
//        $command = new CreateOrder();
//
//        $companyAddress = new Address();
//        $companyAddress->fullAddress = 'Charlottenstr. 4';
//        $companyAddress->postalCode = '10969';
//        $companyAddress->city = 'Berlin';
//        $companyAddress->countryCode = 'DE';
//        $command->debtorCompany = new Company(null, 'Billie GmbH', $companyAddress);
//        $command->debtorCompany->legalForm = '10001';
//        $command->debtorCompany->registrationNumber = '1234567';
//        $command->debtorCompany->registrationCourt = 'Amtsgericht Charlottenburg';
//
//        $command->debtorPerson = new Person('max.mustermann@musterfirma.de');
//        $command->debtorPerson->salution = 'm';
//        $command->debtorPerson->phone = '+4930120111111';
//
//        $command->deliveryAddress = new Address();
//        $command->deliveryAddress->street = 'Waldemarstr. 37a';
//        $command->deliveryAddress->postalCode = '10999';
//        $command->deliveryAddress->city = 'Berlin';
//        $command->deliveryAddress->countryCode = 'DE';
//
//        $command->amount = new Amount(100, 'EUR', 19);
//        $command->duration = 14;
//
//        // Send Order To API
//        $client = BillieClient::create($this->consumerKey, $this->consumerSecretKey,  true);
//        $order = $client->createOrder($command);
//
//        $this->assertNotEmpty($order->referenceId);
//        $this->assertNotEmpty($order->referenceId);
//        $this->assertEquals(Order::STATE_CREATED, $order->state);
//    }
//
//    public function testCreateOrderWithCompanyAddressWithoutHousenumber()
//    {
//        // createOrderCommand
//        $command = new CreateOrder();
//
//        $companyAddress = new Address();
//        $companyAddress->street = 'Charlottenstr. 4f';
//        $companyAddress->postalCode = '10969';
//        $companyAddress->city = 'Berlin';
//        $companyAddress->countryCode = 'DE';
//        $command->debtorCompany = new Company(null, 'Billie GmbH', $companyAddress);
//        $command->debtorCompany->legalForm = '10001';
//        $command->debtorCompany->registrationNumber = '1234567';
//        $command->debtorCompany->registrationCourt = 'Amtsgericht Charlottenburg';
//
//        $command->debtorPerson = new Person('max.mustermann@musterfirma.de');
//        $command->debtorPerson->salution = 'm';
//        $command->debtorPerson->phone = '+4930120111111';
//
//        $command->deliveryAddress = new Address();
//        $command->deliveryAddress->street = 'Waldemarstr.';
//        $command->deliveryAddress->houseNumber = '37a';
//        $command->deliveryAddress->postalCode = '10999';
//        $command->deliveryAddress->city = 'Berlin';
//        $command->deliveryAddress->countryCode = 'DE';
//
//        $command->amount = new Amount(100, 'EUR', 19);
//        $command->duration = 14;
//
//        // Send Order To API
//        $client = BillieClient::create($this->consumerKey, $this->consumerSecretKey,  true);
//        $order = $client->createOrder($command);
//
//        $this->assertNotEmpty($order->referenceId);
//        $this->assertNotEmpty($order->referenceId);
//        $this->assertEquals(Order::STATE_CREATED, $order->state);
//    }
//
//    public function testCreateOrderWithoutCustomerIdAttributes()
//    {
//        // createOrderCommand
//        $command = new CreateOrder();
//
//        $companyAddress = new Address();
//        $companyAddress->street = 'Charlottenstr.';
//        $companyAddress->houseNumber = '4';
//        $companyAddress->postalCode = '10969';
//        $companyAddress->city = 'Berlin';
//        $companyAddress->countryCode = 'DE';
//        $command->debtorCompany = new Company(null, 'Billie GmbH', $companyAddress);
//        $command->debtorCompany->legalForm = '10001';
//        $command->debtorCompany->registrationNumber = '1234567';
//        $command->debtorCompany->registrationCourt = 'Amtsgericht Charlottenburg';
//
//        $command->debtorPerson = new Person('max.mustermann@musterfirma.de');
//        $command->debtorPerson->salution = 'm';
//        $command->debtorPerson->phone = '+4930120111111';
//        $command->deliveryAddress = $companyAddress; // or: new \Billie\Model\Address();
//        $command->amount = new Amount(100, 'EUR', 19);
//
//        $command->duration = 14;
//
//        // Send Order To API
//        $client = BillieClient::create($this->consumerKey, $this->consumerSecretKey,  true);
//        $order = $client->createOrder($command);
//
//        $this->assertNotEmpty($order->referenceId);
//        $this->assertNotEmpty($order->referenceId);
//        $this->assertEquals(Order::STATE_CREATED, $order->state);
//    }
//
//    public function testCreateOrderWithInvalidCommand()
//    {
//        // createOrderCommand
//        $command = new CreateOrder();
//
//        $companyAddress = new Address();
//        $companyAddress->street = 'Charlottenstr.';
//        $companyAddress->houseNumber = '4';
//        $companyAddress->postalCode = '10969';
//        $companyAddress->city = 'Berlin';
//        $companyAddress->countryCode = 'DE';
//        $command->debtorCompany = new Company('BILLIE-00000001', 'Billie GmbH', $companyAddress);
//        $command->debtorCompany->legalForm = '10001';
//        $command->debtorCompany->registrationNumber = '1234567';
//        $command->debtorCompany->registrationCourt = 'Amtsgericht Charlottenburg';
//
//        $command->debtorPerson = new Person('max.mustermann@musterfirma.de');
//        $command->debtorPerson->salution = 'm';
//        $command->debtorPerson->phone = '+4930120111111';
//        $command->deliveryAddress = $companyAddress; // or: new \Billie\Model\Address();
//        $command->amount = new Amount(100, 'EUR', 19);
//
//        $command->duration = null; // WRONG
//
//
//        // Send Order To API
//        $client = BillieClient::create($this->consumerKey, $this->consumerSecretKey,  true);
//
//        $this->expectException(InvalidCommandException::class);
//        $order = $client->createOrder($command);
//    }
//
//    public function testDeclineOrderWithDebtorNotIdentifiedException()
//    {
//        // createOrderCommand
//        $command = new CreateOrder();
//
//        $companyAddress = new Address();
//        $companyAddress->street = 'Hauptstrasse';
//        $companyAddress->houseNumber = '777';
//        $companyAddress->postalCode = '10969';
//        $companyAddress->city = 'Berlin';
//        $companyAddress->countryCode = 'DE';
//        $command->debtorCompany = new Company('BILLIE-00000002', 'Borschella Superpower GmbH', $companyAddress);
//        $command->debtorCompany->legalForm = '10001';
//        $command->debtorCompany->registrationNumber = '1234567';
//        $command->debtorCompany->registrationCourt = 'Amtsgericht Charlottenburg';
//
//        $command->debtorPerson = new Person('johndoe@billie.io');
//        $command->debtorPerson->firstname = 'John';
//        $command->debtorPerson->lastname = 'Doe';
//        $command->debtorPerson->salution = 'm';
//        $command->debtorPerson->phone = '+4930120111112';
//        $command->deliveryAddress = $companyAddress; // or: new \Billie\Model\Address();
//        $command->amount = new Amount(100, 'EUR', 19);
//
//        $command->duration = 14;
//
//        // Send Order To API
//        $client = BillieClient::create($this->consumerKey, $this->consumerSecretKey,  true);
//
//        $this->expectException(DebtorNotIdentifiedException::class);
//        $order = $client->createOrder($command);
//
//    }
//
//    public function testDeclineOrderWithDebtorAddressException()
//    {
//        // createOrderCommand
//        $command = new CreateOrder();
//
//        $companyAddress = new Address();
//        $companyAddress->street = 'Charlottenstr.';
//        $companyAddress->houseNumber = '4';
//        $companyAddress->postalCode = '77777';
//        $companyAddress->city = 'Berlin';
//        $companyAddress->countryCode = 'DE';
//        $command->debtorCompany = new Company('BILLIE-00000001', 'Billie GmbH', $companyAddress);
//        $command->debtorCompany->legalForm = '10001';
//        $command->debtorCompany->registrationNumber = '1234567';
//        $command->debtorCompany->registrationCourt = 'Amtsgericht Charlottenburg';
//
//        $command->debtorPerson = new Person('max.mustermann@musterfirma.de');
//        $command->debtorPerson->salution = 'm';
//        $command->debtorPerson->phone = '+4930120111111';
//        $command->deliveryAddress = $companyAddress; // or: new \Billie\Model\Address();
//        $command->amount = new Amount(100, 'EUR', 19);
//
//        $command->duration = 14;
//
//        // Send Order To API
//        $client = BillieClient::create($this->consumerKey, $this->consumerSecretKey,  true);
//
//        $this->expectException(DebtorAddressException::class);
//        $order = $client->createOrder($command);
//    }
//
//    public function testDeclineOrderWithRiskPolicyException()
//    {
//        // createOrderCommand
//        $command = new CreateOrder();
//
//        $companyAddress = new Address();
//        $companyAddress->street = 'Charlottenstr.';
//        $companyAddress->houseNumber = '4';
//        $companyAddress->postalCode = '77777';
//        $companyAddress->city = 'Berlin';
//        $companyAddress->countryCode = 'GB';
//        $command->debtorCompany = new Company('BILLIE-00000005', 'Billie GmbH', $companyAddress);
//        $command->debtorCompany->legalForm = '10001';
//        $command->debtorCompany->registrationNumber = '1234567';
//        $command->debtorCompany->registrationCourt = 'Amtsgericht Charlottenburg';
//
//        $command->debtorPerson = new Person('max.mustermann@musterfirma.de');
//        $command->debtorPerson->salution = 'm';
//        $command->debtorPerson->phone = '+4930120111111';
//        $command->deliveryAddress = $companyAddress; // or: new \Billie\Model\Address();
//        $command->amount = new Amount(100, 'EUR', 19);
//
//        $command->duration = 14;
//
//        // Send Order To API
//        $client = BillieClient::create($this->consumerKey, $this->consumerSecretKey,  true);
//
//        $this->expectException(RiskPolicyDeclinedException::class);
//        $order = $client->createOrder($command);
//    }
//
//    public function testDeclineOrderWithLimitExceededException()
//    {
//        // createOrderCommand
//        $command = new CreateOrder();
//
//        $companyAddress = new Address();
//        $companyAddress->street = 'Charlottenstr.';
//        $companyAddress->houseNumber = '4';
//        $companyAddress->postalCode = '10969';
//        $companyAddress->city = 'Berlin';
//        $companyAddress->countryCode = 'DE';
//        $command->debtorCompany = new Company('BILLIE-00000001', 'Billie GmbH', $companyAddress);
//        $command->debtorCompany->legalForm = '10001';
//        $command->debtorCompany->registrationNumber = '1234567';
//        $command->debtorCompany->registrationCourt = 'Amtsgericht Charlottenburg';
//
//        $command->debtorPerson = new Person('max.mustermann@musterfirma.de');
//        $command->debtorPerson->salution = 'm';
//        $command->debtorPerson->phone = '+4930120111111';
//        $command->deliveryAddress = $companyAddress; // or: new \Billie\Model\Address();
//        $command->amount = new Amount(3000000, 'EUR', 570000);
//
//        $command->duration = 14;
//
//        // Send Order To API
//        $client = BillieClient::create($this->consumerKey, $this->consumerSecretKey,  true);
//
//        $this->expectException(DebtorLimitExceededException::class);
//        $order = $client->createOrder($command);
//    }
}
