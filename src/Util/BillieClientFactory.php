<?php

namespace Billie\Sdk\Util;

use Billie\Sdk\HttpClient\BillieClient;
use Billie\Sdk\Model\Request\GetTokenRequestModel;
use Billie\Sdk\Service\Request\GetTokenRequest;

class BillieClientFactory
{
    /**
     * @var array<BillieClient>
     */
    private static $instances = [];

    /**
     * @param string $clientId
     * @param string $clientSecret
     * @param bool   $isSandbox
     *
     * @throws \Billie\Sdk\Exception\BillieException
     *
     * @return \Billie\Sdk\HttpClient\BillieClient
     */
    public static function getBillieClientInstance($clientId, $clientSecret, $isSandbox)
    {
        $key = md5(implode('+', [$clientId, $clientSecret, $isSandbox ? '1' : '0']));
        if (isset(self::$instances[$key]) === false) {
            $authToken = self::getAuthToken($clientId, $clientSecret, $isSandbox);
            self::$instances[$key] = new BillieClient($authToken, $isSandbox);
        }

        return self::$instances[$key];
    }

    /**
     * @param string $clientId
     * @param string $clientSecret
     * @param bool   $isSandbox
     *
     * @throws \Billie\Sdk\Exception\BillieException
     *
     * @return string
     */
    public static function getAuthToken($clientId, $clientSecret, $isSandbox)
    {
        $requestService = new GetTokenRequest($isSandbox);

        $response = $requestService->execute(
            (new GetTokenRequestModel())
            ->setClientId($clientId)
            ->setClientSecret($clientSecret)
        );

        return $response->getAccessToken();
    }
}
