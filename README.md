# Billie PHP SDK

The Billie PHP SDK enables you to integrate the REST API of Billie easily and quickly into an existing code base and to use it.


## Requirements
- PHP 5.6 or higher 
- cURL (included and enabled in a standard PHP distribution)
- OpenSSL (included and enabled in a standard PHP distribution)

You need a [Billie account](https://www.billie.io/) to receive the necessary credentials.

## Installation with Composer
You can use the Billie PHP SDK library as a dependency in your project with Composer (preferred technique).

Follow these [installation instructions](https://getcomposer.org/doc/00-intro.md) if you do not already have Composer installed. A composer.json file is available in the repository and it has been referenced from Packagist.

To install the SDK, just execute the following command:
```bash
composer require billie/api-php-sdk
```

Make sure to include the autoloader in your project:
```php
require_once '/path/to/your-project/vendor/autoload.php';
```


## Getting Started

**IMPORTANT**: In Sandbox-Mode no Schufa-Request are made by Billie.
 
```php
// FOR SANDBOX
$client = BillieClient::create([YOUR API KEY], true);
```

```php
// FOR PRODUCTION
$client = BillieClient::create([YOUR API KEY], false);
```

## Usage

### 1. Create Order
The create order request returns either an order or a declined exception (`OrderDeclinedException`) with the reason, if provided by Billie.io. 

**Important:** All amount are in __cents__.
```php
$createOrderCommand = new Billie\Command\CreateOrder();

// Address of the company
$companyAddress = new Billie\Model\Address();
$companyAddress->fullAddress = 'Musterstrasse 12'; //  if set, street and houseNumber will be overwritten
$companyAddress->street = 'Musterstrasse';
$companyAddress->houseNumber = '12'; // if empty, street will be considered as the fullAddress
$companyAddress->postalCode = '12345';
$companyAddress->city = 'Berlin';
$companyAddress->countryCode = 'DE';
    
// Company information, whereas 'CUSTOMER_ID_1' is the merchant's customer id (use _null_ for guest orders)
$command->debtorCompany = new Billie\Model\Company('CUSTOMER_ID_1', 'Muster GmbH', $companyAddress);
$command->debtorCompany->legalForm = '10001';
$command->debtorCompany->registrationNumber = '1234567'; // for GmbH (10001) the "Handelsregisternummer" is required 
$command->debtorCompany->registrationCourt = 'Amtsgericht Charlottenburg';

// Information about the person
$command->debtorPerson = new Billie\Model\Person('max.mustermann@musterfirma.de');
$command->debtorPerson->salution = 'm'; // or: 'f'

// Delivery Address
$command->deliveryAddress = $companyAddress; // or: new \Billie\Model\Address();

// Amount
$command->amount = new Billie\Model\Amount(100, 'EUR', 19); // amounts are in cent!

// Define the due date in DAYS AFTER SHIPPMENT
$command->duration = 14; // meaning: when the order is shipped on the 1st May, the due date is the 15th May

// initialize Billie Client
$client = Billie\HttpClient\BillieClient::create('YOUR_API_KEY', true); // SANDBOX MODE
// or
$client = Billie\HttpClient\BillieClient::create('YOUR_API_KEY', false); // PRODUCTION MODE


try {
    // returns Billie\Model\Order
    $order = $client->createOrder($command);
    $ID_FOR_FURTHER_COMMUNICATION = $order->referenceId;
    
} catch (Billie\Exception\OrderDeclinedException $exception) {
    $message = $exception->getBillieMessage();
    
    // for custom translation
    $messageKey = $exception->getBillieCode();
    $reason = $exception->getReason();
}
```

#### Response
If the order was accepted by Billie, you receive an `order` Object with a `referenceId`. This ID is used for any further communication with Billie.

If the order was declined, you receive an `OrderDeclinedException` with the a reason (provided by Billie). 


### 2. Ship order

**IMPORTANT**: You must provide the corresponding `orderId` of the shop. Since the customer only knows this number, he will use it for the payment and Billie can correctly link the payment to this order.


```php
$command = new Billie\Command\ShipOrder($order->referenceId); // th reference ID was provided by Billie in the createOrder Response.
$command->orderId = 'XY-12345'; // the ORDER ID of the shop, that the customer know
$command->invoiceNumber = '12/0001/2019'; // required, given by merchant
$command->invoiceUrl = 'https://www.example.com/invoice.pdf'; // required, given by merchant
$command->shippingDocumentUrl = 'https://www.example.com/shipping_document.pdf'; // (optional)

try {
    // returns Billie\Model\Order
    $order = $client->shipOrder($command);
    $dueDate = $order->invoice->dueDate;
    
} catch (Billie\Exception\OrderNotShippedException $exception) {
    $message = $exception->getBillieMessage();
    
    // for custom translation
    $messageKey = $exception->getBillieCode();
    $reason = $exception->getReason();
}

```

#### Response
If the shipment was successful, the `order` Object will be returned. The state of the order is now 'shipped'.
Additionally, you'll find the `dueDate` in the response. The `dueDate`has been calculated by Billie:
 
``` SHIPMENT DATE + DURATION (given in `createOrder`) = DUE DATE ```

In case the state did not change to 'shipped', you receive an `OrderNotShippedException` with a reason (provided by Billie).

### 3. Postpone Due date
You can move the due date into the future, if he order is already shipped and the current due date has not been reached.

```php
$command = new Billie\Command\PostponeOrderDueDate($order->referenceId);
$command->duration = 30;

try { 
    // returns Billie\Model\Order
    $order = $client->postponeOrderDueDate($command);
    
    // new Due date
    $dueDate = $order->invoice->dueDate;
    
} catch (Billie\Exception\PostponeDueDateNotAllowedException $exception) {
    $message = $exception->getBillieMessage();
    
    // for custom translation
    $messageKey = $exception->getBillieCode();
}
```

#### Response
If the shipment was successful, the `order` Object will be returned.

### 4. Reduce the order amount
Until the debtor fully paid, you can reduce the amount of the order (e.g. after partial cancellation).

```php
$command = new Billie\Command\ReduceOrderAmount($order->referenceId);
$command->amount = new Billie\Model\Amount(50, 'EUR', 10);

// ONLY if the order has been SHIPPED already, you need to provide a invoice url and invoice number
$command->invoiceNumber = '12/0002/2019';
$command->invoiceUrl = 'https://www.example.com/invoice_new.pdf';

$order = $client->reduceOrderAmount($command);
```

#### Response
If the amount was successfully reduced, the `order` Object will be returned.

### 5. Cancel order
You can cancel the order at any time before the customer fully paid the invoice and the state (at Billie) is COMPLETE.

```php
$command = new Billie\Command\CancelOrder($order->referenceId);

try {
    $client->cancelOrder($command);
    
} catch (Billie\Exception\OrderNotCancelledException $exception) {
    $message = $exception->getBillieMessage();
 
    // for custom translation
    $messageKey = $exception->getBillieCode();   
}
```

#### Response
If the request was successful, the order is cancelled.


### 6. Confirm payment
If the customer, paid the merchant directly. The merchant can inform Billie about the amount with this call.

```php
$command = new Billie\Command\ConfirmPayment($order->referenceId, 119);
        
try {
    $client->confirmPayment($command);
    
} catch (Billie\Exception\BillieException $exception) {
    $message = $exception->getBillieMessage();
 
    // for custom translation
    $messageKey = $exception->getBillieCode();   
}
```

#### Response
If the amount was successfully reported, the `order` Object will be returned.

## Exceptions
Listed below, are all exceptions with their Code. This allows you to map those keys to your custom translation.

You can request the Billie-Code by calling `getBillieCode()` on the exception.

| Billie Code        | Description           | 
| ------------- |-------------|
| `ORDER_DECLINED` | The order was declined by Billie. Please find below possible reasons for that.
| `ORDER_NOT_SHIPPED` | The order could not be shipped. Please check the current state of the order.
| `ORDER_NOT_CANCELLED` | The order could not be cancelled. Possible reasons are, that the order was already fully paid by the customer.
| `POSTPONE_DUE_DATE_NOT_ALLOWED` | The due date of the order could not be postponed. Possible reasons are, that the order already reached the due date or is not shipped yet.
| `ORDER_NOT_FOUND` | The order with the given reference id was not found.
| `INVALID_REQUEST`      | The server declined the request, because of an invalid field or an invalid field value. |
| `NOT_ALLOWED`     | The server responded with a FORBIDDEN response. The action is not allowed.      |  
| `NOT_AUTHORIZED` | The user (identified by the API KEY) is not allowed to perform this action.      |   
| `SERVER_ERROR` | There was an unexpected server error. If that occurs again, please contact Billie.      |   


### Possible Order Decline Reasons

| Billie Reason Code | Description | Default Message (engl) |
|--- | --- | --- |
| `DEBTOR_ADDRESS` | There is a mismatch between the given address and the records of Billie. | _The order was declined, because the address seems to be wrong._ |
| `DEBTOR_NOT_IDENTIFIED` | The debtor could not be identified with the given information. | _The order was declined, because there was no match with the given information._ |
| `RISK_POLICY` | Billie declined the order based on its risk policy. | _The order was declined by Billie due to its risk policy._ |
| `DEBTOR_LIMIT_EXCEEDED` | The financing limit of the debtor has been exceeded. | _The order was declined because the maximum due amount for the debtor has been reached._ | 

## Utility

### Legal Form Provider
In order to accept an order, Billie need information about the debtor company.
Depending on the legal form of the company, the court registration number (_Handelsregisternummer_) or the VAT ID (_Umsatzsteuer-ID_) is required.

The SDK provides the available legal forms together with the mandatory fields:

```php

/**
 * returns an associative array:
 *  [
 *      ...
 *      '10001' => [
 *          'code'                      => '10001'
 *          'label'                     => 'Gesellschaft mit beschränkter Haftung'
 *          'vat_id_required'           => false
 *          'registration_id_required'  => true
 *      ]
 *      ...
 *  ]
 *
 **/ 
 
$allLegalForms = Billie\Util\LegalFormProvider::all();
// or directly request information by legal form (request legal form must match the label from above)
$gmbhInformation = Billie\Util\LegalFormProvider::getInformationFor('Gesellschaft mit beschränkter Haftung');
// or by code
$gmbhInformation = Billie\Util\LegalFormProvider::get('10001');

```

## Developer Documentation
 
[Coding Guideline for Plugin Developers](CODING-GUIDELINE.md)

### Tests
The SDK provide PhpUnit Tests, just run to test the code:
```shell script
vendor/bin/phpunit
```

### Publishing

For some eCommerce software, there is a problem with composer. Therefore it is necessary to commit the `vendor` folder as well.
Before committing and pushing, please run the following command:

```shell script
composer install --no-dev --no-interaction --optimize-autoloader
```
