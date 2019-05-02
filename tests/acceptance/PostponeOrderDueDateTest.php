<?php

namespace Billie\Tests\acceptance;

use Billie\Command\CreateOrder;
use Billie\Command\PostponeOrderDueDate;
use Billie\Command\ShipOrder;
use Billie\HttpClient\BillieClient;
use Billie\Model\Address;
use Billie\Model\Amount;
use Billie\Model\Company;
use Billie\Model\Order;
use Billie\Model\Person;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

/**
 * Class PostponeOrderDueDateTest
 *
 * @package Billie\Tests\acceptance
 * @author Marcel Barten <github@m-barten.de>
 */
class PostponeOrderDueDateTest extends TestCase
{

    private $apiKey = 'test-ralph';


    public function testPostponeOrderDueDateWithValidAttributes()
    {
        // createOrderCommand
        $command = new CreateOrder();

        $companyAddress = new Address();
        $companyAddress->street = 'Charlottenstr.';
        $companyAddress->houseNumber = '4';
        $companyAddress->postalCode = '10969';
        $companyAddress->city = 'Berlin';
        $companyAddress->countryCode = 'DE';
        $command->debtorCompany = new Company('BILLIE-00000001', 'Billie GmbH', $companyAddress);
        $command->debtorCompany->industrySector = '82.99.9';
        $command->debtorCompany->legalForm = '10001';

        $command->debtorPerson = new Person('max.mustermann@musterfirma.de');
        $command->debtorPerson->salution = 'm';
        $command->debtorPerson->phone = '+4930120111111';
        $command->deliveryAddress = $companyAddress; // or: new \Billie\Model\Address();
        $command->amount = new Amount(100, 'EUR', 19);

        $command->duration = 14;

        // Send Order To API
        $client = BillieClient::create($this->apiKey, true);
        $order = $client->createOrder($command);

        $this->assertNotEmpty($order->referenceId);
        $this->assertEquals(Order::STATE_CREATED, $order->state);

        // Ship Order
        $command = new ShipOrder($order->referenceId);
        $command->orderId = Uuid::uuid4()->toString();
        $command->invoiceNumber = '12/122/2019';
        $command->invoiceUrl = 'https://www.googledrive.com/somefile.pdf';

        $order = $client->shipOrder($command);

        $this->assertEquals(Order::STATE_SHIPPED, $order->state);
        $dueDate = new \DateTime('+14 days');
        $this->assertEquals($dueDate->format('Y-m-d'), $order->invoice->dueDate);

        // Postpone DueDate
        $command = new PostponeOrderDueDate($order->referenceId);
        $command->duration = 30;

        $order = $client->postponeOrderDueDate($command);

        $dueDate = new \DateTime('+30 days');
        $this->assertEquals($dueDate->format('Y-m-d'), $order->invoice->dueDate);
    }
}