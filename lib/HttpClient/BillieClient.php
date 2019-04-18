<?php

namespace Billie\HttpClient;

use Billie\Command\CreateOrder;
use Billie\Command\ShipOrder;
use Billie\Exception\BillieException;
use Billie\Exception\InvalidCommandException;
use Billie\Exception\InvalidRequestException;
use Billie\Exception\NotAllowedException;
use Billie\Exception\OrderDeclinedException;
use Billie\Exception\OrderNotFoundException;
use Billie\Exception\OrderNotShippedException;
use Billie\Exception\UnexceptedServerException;
use Billie\Exception\UserNotAuthorizedException;
use Billie\Mapper\CreateOrderMapper;
use Billie\Mapper\ShipOrderMapper;
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
     *  TODO: add public send(Command) and in it, depending on commandinstance run method!
     */


    /**
     * @param CreateOrder $createOrderCommand
     * @return Order
     * @throws BillieException
     *
     */
    public function createOrder(CreateOrder $createOrderCommand)
    {
        // validate input
        if ($violations = $this->validateCommand($createOrderCommand)) {
            throw new InvalidCommandException($violations);
        }

        $data = CreateOrderMapper::arrayFromCreateOrderObject($createOrderCommand);
        $result = $this->request('order', $data);

        // declined orders response with 200 (OK)
        if ($result['state'] === Order::STATE_DECLINED) {
            throw new OrderDeclinedException($result['reasons']);
        }

        return CreateOrderMapper::orderObjectFromArray($result);
    }

    /**
     * @param ShipOrder $shipOrderCommand
     * @return Order
     * @throws BillieException
     *
     */
    public function shipOrder(ShipOrder $shipOrderCommand)
    {
        // validate input
        if ($violations = $this->validateCommand($shipOrderCommand)) {
            throw new InvalidCommandException($violations);
        }

        $data = ShipOrderMapper::arrayFromCommandObject($shipOrderCommand);
        $result = $this->request('order/'.$shipOrderCommand->id.'/ship', $data);

        if ($result['state'] !== Order::STATE_SHIPPED) {
            throw new OrderNotShippedException($shipOrderCommand->id, $result['reasons']);
        }

        return ShipOrderMapper::orderObjectFromArray($result);
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
            'verify'  => false // TODO: remove
        ]);
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
     * @param string $path
     * @param array $data
     * @return array
     * @throws BillieException
     */
    private function request($path, $data)
    {
        $client = $this->getClient();

        try {
            $response = $client->post($path, ['body' => json_encode($data)]);
        } catch (ClientException $exception) {
            if ($exception->getCode() === 400) {
                throw new InvalidRequestException($exception->getMessage());
            }

            if ($exception->getCode() === 401) {
                throw new UserNotAuthorizedException();
            }

            if ($exception->getCode() === 403) {
                throw new NotAllowedException();
            }

            if ($exception->getCode() === 404) {
                throw new OrderNotFoundException($data['order_id'] ?: null);
            }

            if ($exception->getCode() === 500) {
                throw new UnexceptedServerException();
            }
        }

        return json_decode($response->getBody()->getContents(), true);
    }
}