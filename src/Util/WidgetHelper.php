<?php


namespace Billie\Sdk\Util;


class WidgetHelper
{

    const SANDBOX_URL = 'https://static-paella-sandbox.billie.io/checkout/billie-checkout.js';
    const PRODUCTION_URL = 'https://static.billie.io/checkout/billie-checkout.js';

    /**
     * @param $sandbox boolean
     * @return string
     */
    public static function getWidgetUrl($sandbox)
    {
        return $sandbox ? self::SANDBOX_URL : self::PRODUCTION_URL;
    }

}
