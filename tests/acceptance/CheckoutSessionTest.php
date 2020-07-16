<?php

namespace Billie\Tests\acceptance;

use Billie\Command\CheckoutSessionConfirm;
use Billie\HttpClient\BillieClient;
use Billie\Model\DebtorCompany;
use PHPUnit\Framework\TestCase;
use Billie\Model\Amount;

/**
 * Class CheckoutSessionTest
 *
 * @package Billie\Tests\acceptance
 * @author Marcel Barten <github@m-barten.de>
 */
class CheckoutSessionTest extends TestCase
{
    private $consumerKey = 'bfebbc05-d1f0-4e47-be21-c99e7fd2ffcc';
    private $consumerSecretKey = 'cv8hfihix4gso0koc0cgs8wosks4gwwwgo04cg00c4k4okggccg4wo8s88w8c4';


    public function testRetrieveOrderWithValidAttributes()
    {

        $client = BillieClient::create($this->consumerKey, $this->consumerSecretKey,  true);

        $sessionUuid = $client->checkoutSessionCreate('22423432423');

        $command = new CheckoutSessionConfirm($sessionUuid);
        $command->amount = new Amount(100, 'EUR', 19);
        $command->duration = '109';
        $command->debtorCompany = new DebtorCompany();
        $command->debtorCompany->name = 'test_company_1';
        $command->debtorCompany->addressStreet = 'Musterstraße';
        $command->debtorCompany->addressPostalCode = '10909';
        $command->debtorCompany->addressCity = 'Berlin';
        $command->debtorCompany->addressCountry = 'DE';


        $session = $client->checkoutSessionConfirm($command);

        print_r($session);
    }
}