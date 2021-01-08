<?php


namespace Billie\Sdk\Tests\Helper;


use Billie\Sdk\Util\BillieClientFactory;

class BillieClientHelper
{

    public static function getClient()
    {
        return BillieClientFactory::getBillieClientInstance($_ENV['BILLIE_CLIENT_ID'], $_ENV['BILLIE_CLIENT_SECRET'], true);
    }

    public static function getClientId()
    {
        return $_ENV['BILLIE_CLIENT_ID'];
    }

    public static function getClientSecret()
    {
        return $_ENV['BILLIE_CLIENT_SECRET'];
    }
}