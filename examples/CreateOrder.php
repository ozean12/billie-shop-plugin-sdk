<?php

require_once '../vendor/autoload.php';

$client = \Billie\HttpClient\BillieClient::create('THIS IS MY API KEY', true);

$command = new \Billie\Command\CreateOrder();

$companyAddress = new \Billie\Model\Address();
$companyAddress->street = 'An der Ronne';
$companyAddress->houseNumber = '59';
$companyAddress->postalCode = '50859';
$companyAddress->city = 'Köln';
$companyAddress->countryCode = 'DE';
$command->debtorCompany = new \Billie\Model\Company('ABC123', 'Ralph Krämer GmbH', $companyAddress);
$command->debtorCompany->industrySector = 'Garten- und Landschaftsbau';
$command->debtorCompany->legalForm = 'GmbH';

$command->debtorPerson = new \Billie\Model\Person('max.mustermann@musterfirma.de');
$command->deliveryAddress = $companyAddress; // or: new \Billie\Model\Address();
$command->amount = new \Billie\Model\Amount(10000, 'EUR', 1900);

$command->duration = 14;

$response = $client->createOrder($command);



?>