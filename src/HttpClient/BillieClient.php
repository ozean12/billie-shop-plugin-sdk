<?php
/*
 * Copyright (c) Billie GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Billie\Sdk\HttpClient;

use Billie\Sdk\Exception\BillieException;
use Billie\Sdk\Exception\InvalidRequestException;
use Billie\Sdk\Exception\NotAllowedException;
use Billie\Sdk\Exception\OrderNotFoundException;
use Billie\Sdk\Exception\UnexpectedServerResponse;
use Billie\Sdk\Exception\UserNotAuthorizedException;
use RuntimeException;

class BillieClient
{
    /**
     * @var string
     */
    public const METHOD_POST = 'POST';

    /**
     * @var string
     */
    public const METHOD_GET = 'GET';

    /**
     * @var string
     */
    public const METHOD_PUT = 'PUT';

    /**
     * @var string
     */
    public const METHOD_PATCH = 'PATCH';

    //    const METHOD_DELETE = 'DELETE'; // not implemented
    /**
     * @var string
     */
    public const SANDBOX_BASE_URL = 'https://paella-sandbox.billie.io/api/v2/';

    /**
     * @var string
     */
    public const PRODUCTION_BASE_URL = 'https://paella.billie.io/api/v2/';

    private ?string $apiBaseUrl;

    private ?string $authToken;

    public function __construct(string $authToken = null, bool $isSandbox = false)
    {
        $this->authToken = $authToken;
        $this->apiBaseUrl = $isSandbox ? self::SANDBOX_BASE_URL : self::PRODUCTION_BASE_URL;
    }

    /**
     * @throws BillieException
     */
    public function request(string $url, array $data = [], string $method = self::METHOD_GET, bool $addAuthorisationHeader = true): array
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->apiBaseUrl . trim($url, '/'));
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        $requestHeaders = [
            'Content-Type: application/json; charset=UTF-8',
            'Accept: application/json',
            'Cache-Control: no-cache',
            'Pragma: no-cache',
            'Connection: keep-alive',
        ];
        if ($addAuthorisationHeader) {
            if ($this->authToken === null) {
                throw new RuntimeException('no auth-token has been provided in constructor');
            }

            $requestHeaders[] = 'Authorization: Bearer ' . $this->authToken;
        }

        curl_setopt($ch, CURLOPT_HTTPHEADER, $requestHeaders);

        switch ($method) {
            case self::METHOD_POST:
                curl_setopt($ch, CURLOPT_POST, 1);
                break;
            case self::METHOD_PATCH:
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PATCH');
                break;
            case self::METHOD_PUT:
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
                break;
        }

        if ($data !== []) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        }

        //        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        //        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        //        // the number of milliseconds to wait while trying to connect
        //        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT_MS, $connectionTimeout);
        //        // the maximum number of milliseconds to allow cURL functions to execute
        //        curl_setopt($ch, CURLOPT_TIMEOUT_MS, $executionTimeout);

        // use tls v1.2
        curl_setopt($ch, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1_2);

        $response = curl_exec($ch);
        if (is_string($response)) {
            $response = json_decode($response, true);
        }

        $response = is_array($response) ? $response : [];

        $curlInfo = curl_getinfo($ch);

        // close connection
        curl_close($ch);

        switch ($curlInfo['http_code']) {
            case 200:
            case 201:
            case 202:
            case 204:
                return $response;
            case 400:
                throw new InvalidRequestException('Invalid request', $curlInfo['http_code'], $response, $data);
            case 401:
                throw new UserNotAuthorizedException($curlInfo['http_code'], $response, $data);
            case 403:
                throw new NotAllowedException($curlInfo['http_code'], $response, $data);
            case 404:
                preg_match('/order\/(.[^\/]*)\/?/', $url, $matches);
                throw new OrderNotFoundException((string) ($matches && count($matches) === 2 ? $matches[1] : null), $curlInfo['http_code'], $response, $data);
            default:
                throw new UnexpectedServerResponse($curlInfo['http_code'], $response, $data);
        }
    }
}
