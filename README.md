# Billie PHP SDK

The Billie PHP SDK enables you to integrate the REST API of Billie easily and quickly into an existing code base and to
use it.

## Requirements

- PHP 7.4 or higher
- cURL (included and enabled in a standard PHP distribution)
- OpenSSL (included and enabled in a standard PHP distribution)

You need a [Billie account](https://www.billie.io/) to receive the necessary credentials.

## Installation with Composer

You can use the Billie PHP SDK library as a dependency in your project with Composer (preferred technique).

Follow these [installation instructions](https://getcomposer.org/doc/00-intro.md) if you do not already have Composer
installed. A composer.json file is available in the repository, and it has been referenced from Packagist.

To install the SDK, just execute the following command:

```bash
composer require billie/api-php-sdk
```

## Usage

### General usage

For every request there is a

* request service (instance of `\Billie\Sdk\Service\Request\AbstractRequest`)
  Knows anything about the request itself (url, method, authorization)
* request model (instance of `\Billie\Sdk\Model\Response\AbstractRequestModel`)
  Knows anything about the parameters of the request, and acts as DTO to submit the data to the request service
* response model (instance of `\Billie\Sdk\Model\Response\AbstractResponseModel`)
  Knows anything about the response data, and acts as DTO to receives the data from the request service Note: in some
  cases there is not response. Just a `true` if the request was successful

### Get a `\Billie\Sdk\HttpClient\BillieClient`-instance

Use the `\Billie\Sdk\Util\BillieClientFactory` to get a new instance.

The factory will automatically request a new auth-token from the gateway and will store it (with the whole instance) in
a static variable. So it will not produce a new request, if you request a new `BillieClient`-instance.

```php
$isSandbox = true;
$billieClient = \Billie\Sdk\Util\BillieClientFactory::getBillieClientInstance('YOUR-CLIENT-ID', 'YOUR-CLIENT-SECRET', $isSandbox);
```

Provide a boolean as third parameter to define if the request goes against the sandbox or not.

### Get an instance of a request service

You can simply create a new instance of the corresponding class.

*Example*:

```php
/** @var \Billie\Sdk\HttpClient\BillieClient $billieClient **/

$requestService = new \Billie\Sdk\Service\Request\Order\CreateOrderRequest($billieClient);
```

You must not provide the `BillieClient` via the constructor, but you should set it, before calling `execute` on the
request service.

*Example*:

```php
/** @var \Billie\Sdk\HttpClient\BillieClient $billieClient **/

$requestService = new \Billie\Sdk\Service\Request\Order\CreateOrderRequest();
// [...]
$requestService->setClient($billieClient);
// [...]
$requestService->execute(...);
```

### Models

#### Request models: Validation

Every field of a request model (not response models) will be validated automatically, during calling its setter. If you
provide a wrong value or in an invalid format, an `\Billie\Sdk\Exception\Validation\InvalidFieldException` will be
thrown.

You can disable this automatic validation, by calling the method `setValidateOnSet` on the model:

```php
/** @var \Billie\Sdk\Model\Request\AbstractRequestModel $requestModel */

$requestModel->setValidateOnSet(false);
```

The model got validate at least by the request service, to make sure that all data has been provided, and you will get
no validation exception through the gateway.

#### Response models

Every response model is set to be read-only.

You can not set any fields on this model. You will get a `BadMethodCallException`.

### Requests

This documentation should not explain the whole usage of each request. It should only show the main information about
each request, and the main usage.

#### GetTokenRequest

| 	                 | 	                                                           |
|-------------------|-------------------------------------------------------------|
| Api documentation | [Link](https://docs.billie.io/reference/oauth_token_create) |
| Request service   | `\Billie\Sdk\Service\Request\Auth\GetTokenRequest`          |
| Request model     | `\Billie\Sdk\Model\Request\Auth\GetTokenRequestModel`       |
| Response model    | `\Billie\Sdk\Model\Response\Auth\GetTokenResponseModel`     |

With this service you can create a new auth-token for your credentials.

This service got called automatically, if you use the `\Billie\Sdk\Util\BillieClientFactory` to get the `BillieClient`.

This request service is the only one, which do __NOT__ need a `BillieClient`-instance.

__Usage__

```php
$isSandbox = true;
$tokenRequestService = new \Billie\Sdk\Service\Request\Auth\GetTokenRequest($isSandbox);

$requestModel = new \Billie\Sdk\Model\Request\Auth\GetTokenRequestModel();
$requestModel
    ->setClientId('YOUR-CLIENT-ID')
    ->setClientSecret('YOUR-SECRET-ID');
    
/** @var \Billie\Sdk\Model\Response\Auth\GetTokenResponseModel */
$responseModel = $tokenRequestService->execute($requestModel);
$accessToken = $responseModel->getAccessToken(); // use this token for further requests.
```

#### ValidateTokenRequest

| 	                 | 	                                                             |
|-------------------|---------------------------------------------------------------|
| Api documentation | [Link](https://docs.billie.io/reference/oauth_token_validate) |
| Request service   | `\Billie\Sdk\Service\Request\Auth\ValidateTokenRequest`       |
| Request model     | `\Billie\Sdk\Model\Request\Auth\ValidateTokenRequestModel`    |
| Response model    | `\Billie\Sdk\Model\Response\Auth\ValidateTokenResponse`       |

Use this service to verify if your token is still valid. If the token is not valid anymore, you have to request a new
auth-token.

If the token is valid, you will get a response. Otherwise, you will get
an `\Billie\Sdk\Exception\UserNotAuthorizedException`.

__Usage__

```php
/** @var \Billie\Sdk\HttpClient\BillieClient $billieClient */

$validateTokenRequest = new \Billie\Sdk\Service\Request\Auth\ValidateTokenRequest($billieClient);

/** @var \Billie\Sdk\Model\Response\Auth\ValidateTokenResponse $responseModel */
$responseModel = $validateTokenRequest->execute(new \Billie\Sdk\Model\Request\Auth\ValidateTokenRequestModel());
```

Note: the request model does not have any content. Don't be confused.

#### CreateSessionRequest

| 	                 | 	                                                                       |
|-------------------|-------------------------------------------------------------------------|
| Api documentation | [Link](https://developers.billie.io/#operation/checkout_session_create) |
| Request service   | `\Billie\Sdk\Service\Request\CheckoutSession\CreateSessionRequest`      |
| Request model     | `\Billie\Sdk\Model\Request\CheckoutSession\CreateSessionRequestModel`   |
| Response model    | `\Billie\Sdk\Model\Response\CreateSessionResponseModel`                 |

Use this service to create a new checkout session on the gateway for the customer.

__Usage__

```php
/** @var \Billie\Sdk\HttpClient\BillieClient $billieClient */

$requestService = new \Billie\Sdk\Service\Request\CheckoutSession\CreateSessionRequest($billieClient);

$requestModel = new \Billie\Sdk\Model\Request\CheckoutSession\CreateSessionRequestModel();
$requestModel->setMerchantCustomerId('THE-NUMBER-OR-ID-OF-THE-CUSTOMER');

/** @var \Billie\Sdk\Model\Response\CreateSessionResponseModel $responseModel */
$responseModel = $requestService->execute($requestModel);

$checkoutSessionId = $responseModel->getCheckoutSessionId(); // use this session ID and submit it to the widget.
```

#### CheckoutSessionConfirmRequest

| 	                 | 	                                                                              |
|-------------------|--------------------------------------------------------------------------------|
| Api documentation | [Link](https://developers.billie.io/#operation/checkout_session_confirm)       |
| Request service   | `\Billie\Sdk\Service\Request\CheckoutSession\CheckoutSessionConfirmRequest`    |
| Request model     | `\Billie\Sdk\Model\Request\CheckoutSession\CheckoutSessionConfirmRequestModel` |
| Response model    | `\Billie\Sdk\Model\Order`                                                      |

If the user has confirmed the payment (through the widget), you can confirm the order.

It will create an order finally on the gateway.

Note: Please have a look into each model, which field has to be submitted.

__Usage__

```php

/** @var \Billie\Sdk\HttpClient\BillieClient $billieClient */

$requestService = new \Billie\Sdk\Service\Request\CheckoutSession\CheckoutSessionConfirmRequest($billieClient);
$requestModel = new \Billie\Sdk\Model\Request\CheckoutSession\CheckoutSessionConfirmRequestModel();
$requestModel
  ->setSessionUuid('CHECKOUT-SESSION-ID')
  ->setCompany(new \Billie\Sdk\Model\Request\CheckoutSession\Confirm\Debtor())
  ->setAmount(new \Billie\Sdk\Model\Amount())
  ->setDuration(14)
  ->setDeliveryAddress(new \Billie\Sdk\Model\Address());
  
/** @var \Billie\Sdk\Model\Order $responseModel */
$responseModel = $requestService->execute($requestModel); // this is the finally created order
```

#### CreateOrderRequest

| 	                 | 	                                                         |
|-------------------|-----------------------------------------------------------|
| Api documentation | [Link](https://docs.billie.io/reference/order_create_v2)  |
| Request service   | `\Billie\Sdk\Service\Request\Order\CreateOrderRequest`    |
| Request model     | `\Billie\Sdk\Model\Request\Order\CreateOrderRequestModel` |
| Response model    | `\Billie\Sdk\Model\Order`                                 |

This request should be only used, if the seller creates the order manually (telephone, api, ...)

It will create a new order with the initial state of `created` without displaying a widget to confirm.

Note: Please have a look into each model, which field has to be submitted.

__Usage__

```php
/** @var \Billie\Sdk\HttpClient\BillieClient $billieClient */

$requestService = new \Billie\Sdk\Service\Request\Order\CreateOrderRequest($billieClient);

$requestModel = new \Billie\Sdk\Model\Request\Order\CreateOrderRequestModel();
$requestModel
    ->setAmount(new \Billie\Sdk\Model\Amount())
    ->setDuration(12)
    ->setDebtor(new \Billie\Sdk\Model\Request\Order\CreateOrder\Debtor())
    ->setPerson(new \Billie\Sdk\Model\Person())
    ->setComment('order comment')
    ->setExternalCode('merchant-order-number')
    ->setDeliveryAddress(new \Billie\Sdk\Model\Address())
    ->setLineItems([
        new \Billie\Sdk\Model\LineItem(),
        new \Billie\Sdk\Model\LineItem(),
    ])
    
/** @var \Billie\Sdk\Model\Order $responseModel */
$responseModel = $requestService->execute($requestModel); // this is the finally created order
```

This service will throw the following exceptions, which should be handled by the integration:

- `Billie\Sdk\Exception\OrderDecline\DebtorLimitExceededException` - the debtor-limit has been exceeded.
- `Billie\Sdk\Exception\OrderDecline\DebtorNotIdentifiedException` - the gateway was not able to identify the debtor
- `Billie\Sdk\Exception\OrderDecline\InvalidDebtorAddressException` - the gateway was not able to verify the address
- `Billie\Sdk\Exception\OrderDecline\RiskPolicyDeclinedException` - the order got declined for risk reasons
- `Billie\Sdk\Exception\OrderDecline\OrderDeclinedException` - the order got declined by any other reasons

#### UpdateOrderRequest

| 	                 | 	                                                            |
|-------------------|--------------------------------------------------------------|
| Api documentation | [Link](https://developers.billie.io/#operation/order_update) |
| Request service   | `\Billie\Sdk\Service\Request\Order\UpdateOrderRequest`       |
| Request model     | `\Billie\Sdk\Model\Request\Order\UpdateOrderRequestModel`    |
| Response model    | `true`                                                       |

Use this order, to update information about the order. Please have a look into the api documentation, which fields are
updatable. Please also have a look into each model, to find out, which fields this sdk can process.

__Usage__

```php
/** @var \Billie\Sdk\HttpClient\BillieClient $billieClient */

$requestService = new \Billie\Sdk\Service\Request\Order\UpdateOrderRequest($billieClient);
$requestModel = new \Billie\Sdk\Model\Request\Order\UpdateOrderRequestModel('REFERENCE-ID');
$requestModel
  ->setExternalCode('SHOP-ORDER-NUMBER')
  ->setAmount(new \Billie\Sdk\Model\Amount());
  
/** @var true $success */
$success = $requestService->execute($requestModel); // true if successful
```

#### GetOrderRequest

| 	                 | 	                                                                 |
|-------------------|-------------------------------------------------------------------|
| Api documentation | [Link](https://developers.billie.io/#operation/order_get_details) |
| Request service   | `\Billie\Sdk\Service\Request\GetOrderRequest`                     |
| Request model     | `\Billie\Sdk\Model\Request\OrderRequestModel`                     |
| Response model    | `\Billie\Sdk\Model\Order`                                         |

Use this service to retrieve all order information

__Usage__

```php
/** @var \Billie\Sdk\HttpClient\BillieClient $billieClient */

$requestService = new \Billie\Sdk\Service\Request\GetOrderRequest($billieClient);
$requestModel = new \Billie\Sdk\Model\Request\OrderRequestModel('REFERENCE-ID');

/** @var \Billie\Sdk\Model\Order $responseModel */
$responseModel = $requestService->execute($requestModel);
```

#### CreateInvoiceRequest

| 	                 | 	                                                             |
|-------------------|---------------------------------------------------------------|
| Api documentation | [Link](https://docs.billie.io/reference/invoice_create)       |
| Request service   | `\Billie\Sdk\Service\Request\Invoice\CreateInvoiceRequest`    |
| Request model     | `\Billie\Sdk\Model\Request\Invoice\CreateInvoiceRequestModel` |
| Response model    | `\Billie\Sdk\Model\Response\CreateInvoiceResponseModel`       |

Use this service to retrieve all order information

__Usage__

```php
/** @var \Billie\Sdk\HttpClient\BillieClient $billieClient */

$requestService = new \Billie\Sdk\Service\Request\Invoice\CreateInvoiceRequest($billieClient);
$requestModel = new \Billie\Sdk\Model\Request\Invoice\CreateInvoiceRequestModel();
$requestModel
    ->setOrders(['REFERENCE-ID']) // use this method to set Billie reference-id or merchants order-number
    ->setOrderUuId('REFERENCE-UD') // use this method to set Billie reference-id
    ->setOrderExternalCode('MERCHANT_ORDER_ID') // use this method to set merchants order-number
    // to keep your code clean, only use one of the above methods
    ->setInvoiceNumber('merchant-invoice-number')
    ->setInvoiceUrl('https://public-url.com/to/to/merchant-invoice.pdf')
    ->setAmount(
        (new Amount())
            ->setGross(100)
            ->setTaxRate(19.00)
    )
    // optional parameters:
    ->setLineItems([
        new \Billie\Sdk\Model\Request\Invoice\LineItem('merchant-product-id-2', 1),
        new \Billie\Sdk\Model\Request\Invoice\LineItem('merchant-product-id-1', 2)  
    ])
    ->setShippingInformation(new \Billie\Sdk\Model\ShippingInformation())

/** @var \Billie\Sdk\Model\Response\CreateInvoiceResponseModel $responseModel */
$responseModel = $requestService->execute($requestModel);
$uuid = $responseModel->getUuid(); // uuid of the invoice
```

#### GetInvoiceRequest

| 	                 | 	                                                       |
|-------------------|---------------------------------------------------------|
| Api documentation | [Link](https://docs.billie.io/reference/invoice_create) |
| Request service   | `\Billie\Sdk\Service\Request\Invoice\GetInvoiceRequest` |
| Request model     | `\Billie\Sdk\Model\Request\InvoiceRequestModel`         |
| Response model    | `\Billie\Sdk\Model\Response\CreateInvoiceResponseModel` |

Use this service to fetch an invoice.

__Usage__

```php
/** @var \Billie\Sdk\HttpClient\BillieClient $billieClient */

$requestService = new \Billie\Sdk\Service\Request\Invoice\GetInvoiceRequest($billieClient);
$requestModel = new \Billie\Sdk\Model\Request\InvoiceRequestModel('INVOICE-UUID');

/** @var \Billie\Sdk\Model\Invoice $responseModel */
$responseModel = $requestService->execute($requestModel);
```

#### UpdateInvoiceRequest

| 	                 | 	                                                             |
|-------------------|---------------------------------------------------------------|
| Api documentation | [Link](https://docs.billie.io/reference/invoice_update)       |
| Request service   | `\Billie\Sdk\Service\Request\Invoice\UpdateInvoiceRequest`    |
| Request model     | `\Billie\Sdk\Model\Request\Invoice\UpdateInvoiceRequestModel` |
| Response model    | `true`                                                        |

Use this service to update the invoice number or url.

__Usage__

```php
/** @var \Billie\Sdk\HttpClient\BillieClient $billieClient */

$requestService = new \Billie\Sdk\Service\Request\Invoice\UpdateInvoiceRequest($billieClient);
$requestModel = new \Billie\Sdk\Model\Request\Invoice\UpdateInvoiceRequestModel('INVOICE-REFERENCE-UUID');
$requestModel
    ->setInvoiceNumber('merchant-invoice-number')
    ->setInvoiceUrl('https://public-url.com/to/to/merchant-invoice.pdf');

if ($requestService->execute($requestModel)) {
    // invoice has been updated
}
```

#### CancelInvoiceRequest

| 	                 | 	                                                          |
|-------------------|------------------------------------------------------------|
| Api documentation | [Link](https://docs.billie.io/reference/invoice_cancel_v2) |
| Request service   | `\Billie\Sdk\Service\Request\Invoice\CancelInvoiceRequest` |
| Request model     | `\Billie\Sdk\Model\Request\InvoiceRequestModel`            |
| Response model    | `true`                                                     |

Use this service to cancel the invoice.

__Usage__

```php
/** @var \Billie\Sdk\HttpClient\BillieClient $billieClient */

$requestService = new \Billie\Sdk\Service\Request\Invoice\CancelInvoiceRequest($billieClient);
$requestModel = new \Billie\Sdk\Model\Request\InvoiceRequestModel('INVOICE-REFERENCE-UUID');

if ($requestService->execute($requestModel)) {
    // invoice has been deleted/canceled
}
```

#### CreateCreditNoteRequest

| 	                 | 	                                                                |
|-------------------|------------------------------------------------------------------|
| Api documentation | [Link](https://docs.billie.io/reference/create_credit_note)      |
| Request service   | `\Billie\Sdk\Service\Request\Invoice\CreateCreditNoteRequest`    |
| Request model     | `\Billie\Sdk\Model\Request\Invoice\CreateCreditNoteRequestModel` |
| Response model    | `\Billie\Sdk\Model\Response\CreateCreditNoteResponseModel`       |

Use this service to add a (partial) refund/credit-note to an invoice

__Usage__

```php
/** @var \Billie\Sdk\HttpClient\BillieClient $billieClient */

$requestService = new \Billie\Sdk\Service\Request\Invoice\CreateCreditNoteRequest($billieClient);
$requestModel = new \Billie\Sdk\Model\Request\Invoice\CreateCreditNoteRequestModel('INVOICE-UUID', 'MERCHANT/EXTERNAL_CREDIT_NOTE_NUMBER');
$requestModel
    ->setAmount(
        (new Amount())
            ->setGross(100)
            ->setTaxRate(19.00)
    )
    // optional parameters:
    ->setLineItems([
        new \Billie\Sdk\Model\Request\Invoice\LineItem('merchant-product-id-2', 1),
        new \Billie\Sdk\Model\Request\Invoice\LineItem('merchant-product-id-1', 2)  
    ])
    ->setComment('custom comment for refund')

/** @var \Billie\Sdk\Model\Response\CreateInvoiceResponseModel $responseModel */
$responseModel = $requestService->execute($requestModel);
$uuid = $responseModel->getUuid(); // uuid of the invoice
```

#### ConfirmPaymentRequest

| 	                 | 	                                                                     |
|-------------------|-----------------------------------------------------------------------|
| Api documentation | [Link](https://developers.billie.io/#operation/order_payment_confirm) |
| Request service   | `\Billie\Sdk\Service\Request\Invoice\ConfirmPaymentRequest`           |
| Request model     | `\Billie\Sdk\Model\Request\Invoice\ConfirmPaymentRequestModel`        |
| Response model    | `true`                                                                |

Use this request to notify the gateway about a received payment.

__Usage__

```php
/** @var \Billie\Sdk\HttpClient\BillieClient $billieClient */

$requestService = new \Billie\Sdk\Service\Request\Invoice\ConfirmPaymentRequest($billieClient);
$requestModel = new \Billie\Sdk\Model\Request\Invoice\ConfirmPaymentRequestModel('INVOICE-UUID');
$requestModel
    ->setPaidAmount(250);

/** @var true $success */
$success = $requestService->execute($requestModel);
```

#### CancelOrderRequest

| 	                 | 	                                                                     |
|-------------------|-----------------------------------------------------------------------|
| Api documentation | [Link](https://developers.billie.io/#operation/order_payment_confirm) |
| Request service   | `\Billie\Sdk\Service\Request\Order\CancelOrderRequest`                |
| Request model     | `\Billie\Sdk\Model\Request\OrderRequestModel`                         |
| Response model    | `true`                                                                |

Use this request to cancel the order completely.

```php
/** @var \Billie\Sdk\HttpClient\BillieClient $billieClient */

$requestService = new \Billie\Sdk\Service\Request\Order\CancelOrderRequest($billieClient);
$requestModel = new \Billie\Sdk\Model\Request\OrderRequestModel('REFERENCE-ID');

/** @var true $success */
$success = $requestService->execute($requestModel);
```

#### GetLegalFormsRequest

| 	                 | 	                                                               |
|-------------------|-----------------------------------------------------------------|
| Api documentation | [Link](https://developers.billie.io/#operation/get_legal_forms) |
| Request service   | `\Billie\Sdk\Service\Request\GetLegalFormsRequest`              |
| Request model     | `\Billie\Sdk\Model\Request\GetLegalFormsRequestModel`           |
| Response model    | `\Billie\Sdk\Model\Response\GetLegalFormsResponseModel`         |

Use this request to get all legal forms supported by Billie.

Note: This request is always cached. So you can use it anytime without making a new request against the gateway. The
cache will be automatically flushed.

__Usage__

```php
/** @var \Billie\Sdk\HttpClient\BillieClient $billieClient */

$requestService = new \Billie\Sdk\Service\Request\GetLegalFormsRequest($billieClient);
$requestModel = new \Billie\Sdk\Model\Request\GetLegalFormsRequestModel();

/** @var \Billie\Sdk\Model\Response\GetLegalFormsResponseModel $responseModel */
$responseModel = $requestService->execute($requestModel);
```

Note: the request model does not have any content. Don't be confused.

## Integration utilities

### AddressHelper

Class: `\Billie\Util\AddressHelper`
Use this class to separate the house number from the street name.

__Usage__

```php

$streetName = \Billie\Util\AddressHelper::getStreetName('Musterstraße 123'); // will return "Musterstraße"
$houseNumber = \Billie\Util\AddressHelper::getHouseNumber('Musterstraße 123'); // will return "123"
```

### Further features

### Automatic tax amount calculation

Model: `\Billie\Sdk\Model\Amount`

The model has field called `tax`. It contains the tax-amount of the line-item/order

To keep the calculations as simple as possible, you can omit the parameter `tax`. So you must not provide all
information. The model will calculates itself.

_Example 1:_

```php
$amount = new \Billie\Sdk\Model\Amount();
$amount->setGross(119);
$amount->setNet(100);

$tax = $amount->getTax(); // will return `19`
```

_Example 2:_

```php
$amount = new \Billie\Sdk\Model\Amount();
$amount->setGross(119);
$amount->setTaxRate(19);

$tax = $amount->getTax(); // will return `19`
```

_Example 3:_

```php
$amount = new \Billie\Sdk\Model\Amount();
$amount->setNet(100);
$amount->setTaxRate(19);

$tax = $amount->getTax(); // will return `19`
$gross = $amount->getGross(); // will return `119`
```

_Example 4:_

```php
$amount = new \Billie\Sdk\Model\Amount();
$amount->setGross(119);
$amount->setTaxRate(19);

$tax = $amount->getTax(); // will return `19`
$net = $amount->getNet(); // will return `100`
```

_Example 4 (wrong usage):_

If you set the `tax` manually the model will not calculate the values. It will submit the values, as you provide it.

This will end up, that the gateway will give you an error, cause invalid data.

```php

$amount = new \Billie\Sdk\Model\Amount();
$amount->setGross(119);
$amount->setNet(30);
$amount->setTax(40);

$amount->getGross(); // will return `119`
$amount->getNet(); // will return `30`
$amount->getTax(); // will return `40`
```

### Symfony services

If you use a Symfony based system, you can use the request services as a service. So you can inject it very easily. Just
register the request services in your `services.xml` (or yaml)

```xml
<?xml version="1.0" ?>
<container xmlns="http://symfony.com/schema/dic/services"
           xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
           xsi:schemaLocation="http://symfony.com/schema/dic/services http://symfony.com/schema/dic/services/services-1.0.xsd">
    <services>
        <service id="Billie\Sdk\Service\Request\CheckoutSession\CreateSessionRequest" autowire="true"/>
        <service id="Billie\Sdk\Service\Request\Order\CancelOrderRequest" autowire="true"/>
        <service id="Billie\Sdk\Service\Request\CheckoutSession\CheckoutSessionConfirmRequest" autowire="true"/>
        <service id="Billie\Sdk\Service\Request\Order\CreateOrderRequest" autowire="true"/>
        <service id="Billie\Sdk\Service\Request\GetLegalFormsRequest" autowire="true"/>
        <service id="Billie\Sdk\Service\Request\GetOrderRequest" autowire="true"/>
        <service id="Billie\Sdk\Service\Request\Order\UpdateOrderRequest" autowire="true"/>
        <service id="Billie\Sdk\Service\Request\ConfirmPaymentRequest" autowire="true"/>
    </services>
</container>
```

You can just inject the request services to your classes.

_Example:_

```php
<?php
namespace YourNamespace;

class MyClass
{

    /**
     * @var \Billie\Sdk\Service\Request\AbstractRequest
     */
    private $requestService;
    
    public function __construct(\Billie\Sdk\Service\Request\AbstractRequest $requestService) 
    {
        $this->requestService = $requestService;
    }
    
    public function process()
    {
        $response = $this->requestService->execute(...);
    }
}
```

#### Create BillieClient via a factory

Do not forget to define a factory for your `\Billie\Sdk\HttpClient\BillieClient`-instance to get the Client injected
into the request service:

```xml
<?xml version="1.0" ?>
<container xmlns="http://symfony.com/schema/dic/services"
           xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
           xsi:schemaLocation="http://symfony.com/schema/dic/services http://symfony.com/schema/dic/services/services-1.0.xsd">
    <services>
        <service id="YourNamespace\BillieClientFactory"/>
        <service id="Billie\Sdk\HttpClient\BillieClient">
            <factory service="YourNamespace\BillieClientFactory" method="createBillieClient"/>
        </service>
    </services>
</container>
```

```php
<?php
namespace YourNamespace;

class BillieClientFactory
{
    public function createBillieClient()
    {
        $isSandbox = true;
        return \Billie\Sdk\Util\BillieClientFactory::getBillieClientInstance(
            'YOUR-CLIENT-ID',
            'YOUR-CLIENT-SECRET',
            $isSandbox
        );
    }
}
```

#### Provide BillieClient via setter

If you can not use the factory to create an instance of `\Billie\Sdk\HttpClient\BillieClient`, you can also set the
BillieClient manually to the request service:

```php
/* @var \Billie\Sdk\Service\Request\AbstractRequest $requestService */
$isSandbox = true;
$requestService->setClient(new \Billie\Sdk\HttpClient\BillieClient('YOUR-CLIENT-ID', 'YOUR-CLIENT-SECRET', $isSandbox));
```