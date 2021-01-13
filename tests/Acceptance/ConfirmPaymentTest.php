<?php

namespace Billie\Tests\acceptance;

use Billie\Command\ConfirmPayment;
use Billie\Command\CreateOrder;
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
 * Class ConfirmPaymentTest
 *
 * @package Billie\Tests\acceptance
 * @author Marcel Barten <github@m-barten.de>
 */
class ConfirmPaymentTest extends TestCase
{
    private $consumerKey = 'bfebbc05-d1f0-4e47-be21-c99e7fd2ffcc';
    private $consumerSecretKey = 'cv8hfihix4gso0koc0cgs8wosks4gwwwgo04cg00c4k4okggccg4wo8s88w8c4';

    public function testConfirmPaymentWithValidAttributes()
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
        $order = $client->createOrder($command);

        $this->assertNotEmpty($order->referenceId);
        $this->assertEquals(Order::STATE_CREATED, $order->state);

        // Ship Order
        $command = new ShipOrder($order->referenceId);
        $command->orderId = Uuid::uuid4()->toString();
        $command->invoiceNumber = '12/122/2019';
        $command->invoiceUrl = 'https://www.googledrive.com/somefile.pdf';
        $order = $client->shipOrder($command);

        // Confirm Payment
        $command = new ConfirmPayment($order->referenceId, 119);
        $client->confirmPayment($command);

    }
}