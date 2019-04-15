<?php

namespace Billie\HttpClient;

use Billie\Command\CreateOrder;
use Billie\Exception\InvalidCommandException;
use Billie\Exception\OrderDeclinedException;
use Billie\Mapper\OrderMapper;
use Billie\Model\Order;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class BillieClient
 *
 * @package Billie\HttpClient
 * @author Marcel Barten <github@m-barten.de>
 */
class BillieClient implements ClientInterface
{
    const SANDBOX_BASE_URL = 'https://paella-sandbox.billie.io/api/v1/';
    const PRODUCTION_BASE_URL = 'https://paella.billie.io/api/v1/';

    private $apiBaseUrl;
    private $apiKey;

    private $validator;

    /**
     * BillieClient constructor.
     *
     * @param ValidatorInterface $validator
     */
    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    /**
     * @param string $apiKey
     * @param bool $sandboxMode
     * @return BillieClient
     */
    public static function create($apiKey, $sandboxMode = true)
    {
        $validator = Validation::createValidatorBuilder()
                               ->addMethodMapping('loadValidatorMetadata')
                               ->getValidator();

        $client = new self($validator);
        $client->apiKey = $apiKey;
        $client->apiBaseUrl = $sandboxMode ? self::SANDBOX_BASE_URL : self::PRODUCTION_BASE_URL;

        return $client;
    }

    /**
     * @param CreateOrder $createOrderCommand
     * @return Order
     * @throws OrderDeclinedException
     * @throws InvalidCommandException
     *
     * TODO: exceptions
     */
    public function createOrder(CreateOrder $createOrderCommand)
    {
        // validate input
        if ($violations = $this->validateCommand($createOrderCommand)) {
            throw new InvalidCommandException($violations);
        }

        $client = $this->getClient();
        $data = OrderMapper::arrayFromCreateOrderObject($createOrderCommand);
        $result = [];

        try {
            $response = $client->post('order', ['body' => json_encode($data)]);
            $result = json_decode($response->getBody()->getContents(), true);

            // declined orders response with 200 (OK)
            if ($result['state'] === Order::STATE_DECLINED) {
                throw new OrderDeclinedException($result['reasons']);
            }


        } catch (ClientException $exception) {
            /**
             * if code === 400, throw ...
             */
        }

        return OrderMapper::objectFromArray($result);
    }

    /**
     * @param $command
     * @return array
     */
    private function validateCommand($command)
    {
        $errors = $this->validator->validate($command);
        $violations = [];

        if (count($errors) > 0) {
            $errorsString = (string) $errors;
            $violations[] = $errorsString;
        }

        return $violations;
    }

    /**
     * @return Client
     */
    private function getClient()
    {
        return new Client([
            'base_uri'  => $this->apiBaseUrl,
            'headers'   => [
                'X-API-KEY' => $this->apiKey,
                'Content-Type' => 'application/json'
            ],
        ]);
    }

}