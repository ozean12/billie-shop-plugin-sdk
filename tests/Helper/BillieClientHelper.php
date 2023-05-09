<?php
/*
 * Copyright (c) Billie GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Billie\Sdk\Tests\Helper;

use Billie\Sdk\HttpClient\BillieClient;
use Billie\Sdk\Util\BillieClientFactory;

class BillieClientHelper
{
    public static function getClient(): BillieClient
    {
        return BillieClientFactory::getBillieClientInstance(self::getClientId(), self::getClientSecret(), true);
    }

    public static function getClientId(): string
    {
        return (string) getenv('BILLIE_CLIENT_ID');
    }

    public static function getClientSecret(): string
    {
        return (string) getenv('BILLIE_CLIENT_SECRET');
    }
}
