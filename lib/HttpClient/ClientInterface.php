<?php

namespace Billie\HttpClient;

/**
 * Interface ClientInterface
 *
 * @package Billie\HttpClient
 * @author Marcel Barten <github@m-barten.de>
 */
interface ClientInterface
{
    public static function create($apiKey, $sandboxMode);
}