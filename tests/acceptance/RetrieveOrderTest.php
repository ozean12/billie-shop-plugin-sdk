<?php

namespace Billie\Tests\acceptance;

use Billie\Command\CreateOrder;
use Billie\HttpClient\BillieClient;
use Billie\Model\Address;
use Billie\Model\Amount;
use Billie\Model\Company;
use Billie\Model\Order;
use Billie\Model\Person;
use PHPUnit\Framework\TestCase;

/**
 * Class RetrieveOrderTest
 *
 * @package Billie\Tests\acceptance
 * @author Marcel Barten <github@m-barten.de>
 */
class RetrieveOrderTest extends TestCase
{
    private $apiKey = 'test-ralph';


    public function testRetrieveOrderWithValidAttributes()
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
        $this->assertEquals(Order::STATE_CREATED, $order->state);

        // Retrieve Order
        $order = $client->getOrder($order->referenceId);

        $this->assertEquals(Order::STATE_CREATED, $order->state);
    }
}