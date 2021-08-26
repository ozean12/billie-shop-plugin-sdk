<?php

namespace Billie\Sdk\Tests\Helper;

use Billie\Sdk\Util\BillieClientFactory;

class BillieClientHelper
{
    public static function getClient()
    {
        return BillieClientFactory::getBillieClientInstance(self::getClientId(), self::getClientSecret(), true);
    }

    public static function getClientId()
    {
        return getenv('BILLIE_CLIENT_ID');
    }

    public static function getClientSecret()
    {
        return getenv('BILLIE_CLIENT_SECRET');
    }
}
