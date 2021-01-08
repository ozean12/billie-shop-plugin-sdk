<?php


namespace Billie\Sdk\Util;


use Billie\Sdk\HttpClient\BillieClient;
use Billie\Sdk\Model\Request\GetTokenRequestModel;
use Billie\Sdk\Service\Request\GetTokenRequest;

class BillieClientFactory
{

    private static $instances = [];


    public static function getBillieClientInstance($clientId, $clientSecret, $isSandbox)
    {
        $key = md5(implode([$clientId, $clientSecret, $isSandbox ? '1' : '0']));
        if (isset(self::$instances[$key]) === false) {
            $authToken = self::getAuthToken($clientId, $clientSecret, $isSandbox);
            self::$instances[$key] = new BillieClient($authToken, $isSandbox);
        }
        return self::$instances[$key];
    }

    public static function getAuthToken($clientId, $clientSecret, $isSandbox)
    {
        $requestService = new GetTokenRequest($isSandbox);

        $response = $requestService->execute(new GetTokenRequestModel(
            $clientId,
            $clientSecret
        ));

        return $response->getAccessToken();
    }

}