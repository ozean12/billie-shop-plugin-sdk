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

```php
// FOR SANDBOX
$client = BillieClient::create([YOUR API KEY], true);

// FOR PRODUCTION
$client = BillieClient::create([YOUR API KEY], false);
```

### Configuration

### Sample Usage

#### Create Order
```php
$createOrderCommand = new Billie\Command\CreateOrder();

```

## Unit Tests

## License


