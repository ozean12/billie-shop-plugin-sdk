<?php

declare(strict_types=1);

namespace Billie\Sdk\Util;

use Billie\Sdk\Exception\BillieException;
use Billie\Sdk\HttpClient\BillieClient;
use Billie\Sdk\Model\Request\GetTokenRequestModel;
use Billie\Sdk\Service\Request\GetTokenRequest;

class BillieClientFactory
{
    /**
     * @var BillieClient[]
     */
    private static array $instances = [];

    /**
     * @throws BillieException
     */
    public static function getBillieClientInstance(string $clientId, string $clientSecret, bool $isSandbox): BillieClient
    {
        $key = md5(implode('+', [$clientId, $clientSecret, $isSandbox ? '1' : '0']));
        if (!isset(self::$instances[$key])) {
            $authToken = self::getAuthToken($clientId, $clientSecret, $isSandbox);
            self::$instances[$key] = new BillieClient($authToken, $isSandbox);
        }

        return self::$instances[$key];
    }

    /**
     * @throws BillieException
     */
    public static function getAuthToken(string $clientId, string $clientSecret, bool $isSandbox): string
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
