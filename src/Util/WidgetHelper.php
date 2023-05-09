<?php
/*
 * Copyright (c) Billie GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Billie\Sdk\Util;

class WidgetHelper
{
    /**
     * @var string
     */
    public const SANDBOX_URL = 'https://static-paella-sandbox.billie.io/checkout/billie-checkout.js';

    /**
     * @var string
     */
    public const PRODUCTION_URL = 'https://static.billie.io/checkout/billie-checkout.js';

    public static function getWidgetUrl(bool $sandbox): string
    {
        return $sandbox ? self::SANDBOX_URL : self::PRODUCTION_URL;
    }
}
