<?php

namespace Billie\Tests\acceptance;

use Billie\Command\CreateOrder;
use Billie\Exception\InvalidCommandException;
use Billie\Exception\OrderDeclinedException;
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
final class CreateOrderTest extends TestCase
{
    private $apiKey = 'test-ralph';


    public function testCreateOrderWithValidAttributes()
    {
        // createOrderCommand
        $command = new CreateOrder();

        $companyAddress = new Address();
        $companyAddress->street = 'An der Ronne';
        $companyAddress->houseNumber = '59';
        $companyAddress->postalCode = '50859';
        $companyAddress->city = 'Köln';
        $companyAddress->countryCode = 'DE';
        $command->debtorCompany = new Company('ABC123', 'Ralph Krämer GmbH', $companyAddress);
        $command->debtorCompany->industrySector = 'Garten- und Landschaftsbau';
        $command->debtorCompany->legalForm = 'GmbH';

        $command->debtorPerson = new Person('max.mustermann@musterfirma.de');
        $command->debtorPerson->salution = 'm';
        $command->deliveryAddress = $companyAddress; // or: new \Billie\Model\Address();
        $command->amount = new Amount(100, 'EUR', 19);

        $command->duration = 14;

        // Send Order To API
        $client = BillieClient::create($this->apiKey, true);
        $order = $client->createOrder($command);

        $this->assertNotEmpty($order->referenceId);
        $this->assertNotEmpty($order->referenceId);
        $this->assertEquals(Order::STATE_CREATED, $order->state);
    }

    public function testCreateOrderWithInvalidCommand()
    {
        // createOrderCommand
        $command = new CreateOrder();

        $companyAddress = new Address();
        $companyAddress->street = 'An der Ronne';
        $companyAddress->houseNumber = '59';
        $companyAddress->postalCode = '504859'; //
        $companyAddress->city = 'Köln';
        $companyAddress->countryCode = 'DE';
        $command->debtorCompany = new Company('ABC123', 'Ralph Krämer GmbH', $companyAddress);
        $command->debtorCompany->industrySector = 'Garten- und Landschaftsbau';
        //$command->debtorCompany->legalForm = 'GmbH';

        $command->debtorPerson = new Person('max.mustermann@musterfirma.de');
        $command->debtorPerson->salution = 'd';
        $command->deliveryAddress = $companyAddress; // or: new \Billie\Model\Address();
        $command->amount = new Amount(100, 'WRONG_CURRENCY', 19);

        $command->duration = null; // WRONG DURATION


        // Send Order To API
        $client = BillieClient::create($this->apiKey, true);

        $this->expectException(InvalidCommandException::class);
        $order = $client->createOrder($command);
    }

    public function testDeclinedOrder()
    {
        // createOrderCommand
        $command = new CreateOrder();

        $companyAddress = new Address();
        $companyAddress->street = 'An der Ronne';
        $companyAddress->houseNumber = '59';
        $companyAddress->postalCode = '50859';
        $companyAddress->city = 'Köln';
        $companyAddress->countryCode = 'DE';
        $command->debtorCompany = new Company('ZYX', 'highdigital UG', $companyAddress);
        $command->debtorCompany->industrySector = 'Garten- und Landschaftsbau';
        $command->debtorCompany->legalForm = 'UG';

        $command->debtorPerson = new Person('max.mustermann@musterfirma.de');
        $command->debtorPerson->salution = 'm';
        $command->deliveryAddress = $companyAddress; // or: new \Billie\Model\Address();
        $command->amount = new Amount(100, 'EUR', 19);

        $command->duration = 14;

        // Send Order To API
        $client = BillieClient::create($this->apiKey, true);

        $this->expectException(OrderDeclinedException::class);
        $order = $client->createOrder($command);
    }
}