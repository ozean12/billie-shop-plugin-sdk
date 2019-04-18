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
    /**
     * @param string $apiKey
     * @param boolean $sandboxMode
     * @return BillieClient
     */
    public static function create($apiKey, $sandboxMode);
}