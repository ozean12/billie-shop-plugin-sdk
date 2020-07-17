<?php

namespace Billie\HttpClient;

use Billie\Command\CancelOrder;
use Billie\Command\CheckoutSessionConfirm;
use Billie\Command\ConfirmPayment;
use Billie\Command\CreateOrder;
use Billie\Command\PostponeOrderDueDate;
use Billie\Command\PreapproveCreateOrder;
use Billie\Command\PreapproveConfirmOrder;
use Billie\Command\RetrieveOrder;
use Billie\Command\ShipOrder;
use Billie\Command\ReduceOrderAmount;
use Billie\Command\CheckoutSession;
use Billie\Command\UpdateOrder;
use Billie\Exception\BillieException;
use Billie\Exception\InvalidCommandException;
use Billie\Exception\InvalidFullAddressException;
use Billie\Exception\InvalidRequestException;
use Billie\Exception\NotAllowedException;
use Billie\Exception\OrderDecline\DebtorAddressException;
use Billie\Exception\OrderDecline\DebtorLimitExceededException;
use Billie\Exception\OrderDecline\DebtorNotIdentifiedException;
use Billie\Exception\OrderDecline\RiskPolicyDeclinedException;
use Billie\Exception\OrderNotCancelledException;
use Billie\Exception\OrderNotFoundException;
use Billie\Exception\OrderNotShippedException;
use Billie\Exception\PostponeDueDateNotAllowedException;
use Billie\Exception\UnexceptedServerException;
use Billie\Exception\UserNotAuthorizedException;
use Billie\Mapper\ConfirmPaymentMapper;
use Billie\Mapper\CreateOrderMapper;
use Billie\Mapper\RetrieveOrderMapper;
use Billie\Mapper\ShipOrderMapper;
use Billie\Mapper\UpdateOrderMapper;
use Billie\Mapper\CheckoutSessionConfirmMapper;
use Billie\Model\Order;
use Billie\Util\AddressHelper;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\HandlerStack;
use kamermans\OAuth2\GrantType\ClientCredentials;
use kamermans\OAuth2\OAuth2Subscriber;
use kamermans\OAuth2\OAuth2Middleware;
use kamermans\OAuth2\Utils\Helper;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use League\OAuth2\Client\Provider\GenericProvider;


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

    private $validator;
    private $accessToken;

    private $consumerKey;
    private $consumerSecretKey;
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
    public static function create($consumerKey, $consumerSecretKey, $sandboxMode = true)
    {
        $validator = Validation::createValidatorBuilder()
            ->addMethodMapping('loadValidatorMetadata')
            ->getValidator();

        $client = new self($validator);
        $client->consumerKey = $consumerKey;
        $client->consumerSecretKey = $consumerSecretKey;
//        $client->apiKey = $apiKey;
        $client->apiBaseUrl = $sandboxMode ? self::SANDBOX_BASE_URL : self::PRODUCTION_BASE_URL;

        return $client;
    }


    public function checkoutSessionCreate($merchantCustomerId)
    {

        $checkoutSessionCommand = new CheckoutSession($merchantCustomerId);

        // validate input
        if ($violations = $this->validateCommand($checkoutSessionCommand)) {
            throw new InvalidCommandException($violations);
        }
        $data = array('merchant_customer_id' => $merchantCustomerId);

        $result = $this->request('checkout-session', $data );

        return $result['id'];

    }

    public function checkoutSessionConfirm(CheckoutSessionConfirm $checkoutSessionConfirm)
    {

        // validate input
        if ($violations = $this->validateCommand($checkoutSessionConfirm)) {
            throw new InvalidCommandException($violations);
        }

        $data = CheckoutSessionConfirmMapper::arrayFromCommandObject($checkoutSessionConfirm);

        $result = $this->request('checkout-session/'.$checkoutSessionConfirm->uuid.'/confirm',$data , 'PUT' );

        return $result;

    }


    /**
     * @param string $orderId
     * @return Order
     * @throws InvalidCommandException
     * @throws BillieException
     */
    public function getOrder($orderId)
    {
        $retrieveOrderCommand = new RetrieveOrder($orderId);

        // validate input
        if ($violations = $this->validateCommand($retrieveOrderCommand)) {
            throw new InvalidCommandException($violations);
        }

        $result = $this->get('order', $orderId);

        return RetrieveOrderMapper::orderObjectFromArray($result);
    }

    public function preapproveCreateOrder(PreapproveCreateOrder $preapproveCreateOrderCommand)
    {
        // if houseNumber is empty, set fullAddress to trigger full-address-recognition
        if (!isset($preapproveCreateOrderCommand->debtorCompany->address->fullAddress)
            && empty($preapproveCreateOrderCommand->debtorCompany->address->houseNumber)) {
            $preapproveCreateOrderCommand->debtorCompany->address->fullAddress = $preapproveCreateOrderCommand->debtorCompany->address->street;
        }

        // set address parts from fullAddress
        if (isset($preapproveCreateOrderCommand->debtorCompany->address->fullAddress)) {
            try {
                $addressPartial = AddressHelper::getPartsFromFullAddress(
                    $preapproveCreateOrderCommand->debtorCompany->address->fullAddress
                );

                $preapproveCreateOrderCommand->debtorCompany->address->street = $addressPartial->street;
                $preapproveCreateOrderCommand->debtorCompany->address->houseNumber = $addressPartial->houseNumber;
            } catch (InvalidFullAddressException $exception) {
                // what happens, if there is a strange address?
                $preapproveCreateOrderCommand->debtorCompany->address->street = $preapproveCreateOrderCommand->debtorCompany->address->fullAddress;
                $preapproveCreateOrderCommand->debtorCompany->address->houseNumber = " ";
            }
        }

        // if houseNumber is empty, set fullAddress to trigger full-address-recognition
        if (!isset($preapproveCreateOrderCommand->deliveryAddress->fullAddress)
            && empty($preapproveCreateOrderCommand->deliveryAddress->houseNumber)) {
            $preapproveCreateOrderCommand->deliveryAddress->fullAddress = $preapproveCreateOrderCommand->deliveryAddress->street;
        }

        if (isset($preapproveCreateOrderCommand->deliveryAddress->fullAddress)) {
            try {
                $addressPartial = AddressHelper::getPartsFromFullAddress(
                    $preapproveCreateOrderCommand->deliveryAddress->fullAddress
                );

                $preapproveCreateOrderCommand->deliveryAddress->street = $addressPartial->street;
                $preapproveCreateOrderCommand->deliveryAddress->houseNumber = $addressPartial->houseNumber;
            } catch (InvalidFullAddressException $exception) {
                // what happens, if there is a strange address?
                $preapproveCreateOrderCommand->deliveryAddress->street = $preapproveCreateOrderCommand->deliveryAddress->fullAddress;
                $preapproveCreateOrderCommand->deliveryAddress->houseNumber = " ";
            }
        }


        // validate input
        if ($violations = $this->validateCommand($preapproveCreateOrderCommand)) {
            throw new InvalidCommandException($violations);
        }

        $data = CreateOrderMapper::arrayFromCreateOrderObject($preapproveCreateOrderCommand);
        $result = $this->request('order/pre-approve', $data);

        // declined orders response with 200 (OK)
        if ($result['state'] === Order::STATE_DECLINED) {
            $this->throwOrderDeclinedException($result['reasons']);
        }

        return $this->getOrder($result['uuid']);
    }


    public function preapproveConfirmOrder(PreapproveConfirmOrder $command)
    {

        // validate input
        if ($violations = $this->validateCommand($command)) {
            throw new InvalidCommandException($violations);
        }

        $data = array();
        $result = $this->request('order/'.$command->id.'/confirm', $data );

        return $this->getOrder($result['uuid']);

    }

    /**
     * @param CreateOrder $createOrderCommand
     * @return Order
     * @throws InvalidCommandException
     * @throws BillieException
     *
     */
    public function createOrder(CreateOrder $createOrderCommand)
    {
        // if houseNumber is empty, set fullAddress to trigger full-address-recognition
        if (!isset($createOrderCommand->debtorCompany->address->fullAddress)
            && empty($createOrderCommand->debtorCompany->address->houseNumber)) {
            $createOrderCommand->debtorCompany->address->fullAddress = $createOrderCommand->debtorCompany->address->street;
        }

        // set address parts from fullAddress
        if (isset($createOrderCommand->debtorCompany->address->fullAddress)) {
            try {
                $addressPartial = AddressHelper::getPartsFromFullAddress(
                    $createOrderCommand->debtorCompany->address->fullAddress
                );

                $createOrderCommand->debtorCompany->address->street = $addressPartial->street;
                $createOrderCommand->debtorCompany->address->houseNumber = $addressPartial->houseNumber;
            } catch (InvalidFullAddressException $exception) {
                // what happens, if there is a strange address?
                $createOrderCommand->debtorCompany->address->street = $createOrderCommand->debtorCompany->address->fullAddress;
                $createOrderCommand->debtorCompany->address->houseNumber = " ";
            }
        }

        // if houseNumber is empty, set fullAddress to trigger full-address-recognition
        if (!isset($createOrderCommand->deliveryAddress->fullAddress)
            && empty($createOrderCommand->deliveryAddress->houseNumber)) {
            $createOrderCommand->deliveryAddress->fullAddress = $createOrderCommand->deliveryAddress->street;
        }

        if (isset($createOrderCommand->deliveryAddress->fullAddress)) {
            try {
                $addressPartial = AddressHelper::getPartsFromFullAddress(
                    $createOrderCommand->deliveryAddress->fullAddress
                );

                $createOrderCommand->deliveryAddress->street = $addressPartial->street;
                $createOrderCommand->deliveryAddress->houseNumber = $addressPartial->houseNumber;
            } catch (InvalidFullAddressException $exception) {
                // what happens, if there is a strange address?
                $createOrderCommand->deliveryAddress->street = $createOrderCommand->deliveryAddress->fullAddress;
                $createOrderCommand->deliveryAddress->houseNumber = " ";
            }
        }


        // validate input
        if ($violations = $this->validateCommand($createOrderCommand)) {
            throw new InvalidCommandException($violations);
        }

        $data = CreateOrderMapper::arrayFromCreateOrderObject($createOrderCommand);
        $result = $this->request('order', $data);

        // declined orders response with 200 (OK)
        if ($result['state'] === Order::STATE_DECLINED) {
            $this->throwOrderDeclinedException($result['reasons']);
        }

        return $this->getOrder($result['uuid']);
    }

    /**
     * @param UpdateOrder $command
     * @return Order
     * @throws BillieException
     * @throws InvalidCommandException
     */
    public function updateOrder(UpdateOrder $command)
    {
        // validate input
        if ($violations = $this->validateCommand($command)) {
            throw new InvalidCommandException($violations);
        }

        // validate with order state
        $order = $this->getOrder($command->referenceId);

        $data = UpdateOrderMapper::arrayFromCommandObject($command);
        $this->request('order/'.$command->referenceId, $data, 'PATCH');

        return $this->getOrder($command->referenceId);
    }

    /**
     * @param ReduceOrderAmount $command
     * @return Order
     * @throws InvalidCommandException
     * @throws BillieException
     */
    public function reduceOrderAmount(ReduceOrderAmount $command)
    {
        // validate input
        if ($violations = $this->validateCommand($command)) {
            throw new InvalidCommandException($violations);
        }

        // validate with order state
        $order = $this->getOrder($command->referenceId);
        if ($order->state === Order::STATE_SHIPPED) {
            if (empty($command->invoiceUrl) || empty($command->invoiceNumber)) {
                throw new InvalidCommandException(['Since the order is marked as SHIPPED, you need to provide an invoice_url and an invoice_number!']);
            }
        }

        $data = UpdateOrderMapper::arrayFromCommandObject($command);
        $this->request('order/'.$command->referenceId, $data, 'PATCH');

        return $this->getOrder($command->referenceId);
    }

    /**
     * @param PostponeOrderDueDate $command
     * @return Order
     * @throws InvalidCommandException
     * @throws BillieException
     */
    public function postponeOrderDueDate(PostponeOrderDueDate $command)
    {
        // validate input
        if ($violations = $this->validateCommand($command)) {
            throw new InvalidCommandException($violations);
        }

        // validate with order state
        // update duration ONLY if due date is in the future AND state = SHIPPED
        $order = $this->getOrder($command->referenceId);
        if ($order->state !== Order::STATE_SHIPPED
            || strtotime($order->invoice->dueDate . ' 00:00:00.0') < time())
        {
            throw new PostponeDueDateNotAllowedException($order->referenceId);
        }

        $data = UpdateOrderMapper::arrayFromCommandObject($command);
        $this->request('order/'.$command->referenceId, $data, 'PATCH');

        return $this->getOrder($command->referenceId);

    }

    /**
     * @param ShipOrder $shipOrderCommand
     * @return Order
     * @throws InvalidCommandException
     * @throws BillieException
     */
    public function shipOrder(ShipOrder $shipOrderCommand, $submitExternalOrderId = false)
    {
        // validate input
        if ($violations = $this->validateCommand($shipOrderCommand)) {
            throw new InvalidCommandException($violations);
        }

        $data = ShipOrderMapper::arrayFromCommandObject($shipOrderCommand, $submitExternalOrderId);
        $result = $this->request('order/'.$shipOrderCommand->referenceId.'/ship', $data);

        if ($result['state'] !== Order::STATE_SHIPPED) {
            throw new OrderNotShippedException($shipOrderCommand->referenceId, $result['reasons']);
        }

        return ShipOrderMapper::orderObjectFromArray($result);
    }

    /**
     * @param ConfirmPayment $command
     * @return Order
     * @throws BillieException
     * @throws InvalidCommandException
     */
    public function confirmPayment (ConfirmPayment $command)
    {
        // validate input
        if ($violations = $this->validateCommand($command)) {
            throw new InvalidCommandException($violations);
        }

        $data = ConfirmPaymentMapper::arrayFromCommandObject($command);
        $this->request('order/'.$command->referenceId . '/confirm-payment', $data);

        return $this->getOrder($command->referenceId);
    }

    /**
     * @param CancelOrder $command
     * @throws InvalidCommandException
     * @throws BillieException
     */
    public function cancelOrder(CancelOrder $command)
    {
        // validate input
        if ($violations = $this->validateCommand($command)) {
            throw new InvalidCommandException($violations);
        }

        // validate with order state
        // cancel order only if state is not COMPLETE
        $order = $this->getOrder($command->referenceId);
        if ($order->state === Order::STATE_COMPLETED) {
            throw new OrderNotCancelledException($command->referenceId);
        }

        try {
            $this->request('order/' . $command->referenceId . '/cancel', []);
        } catch (BillieException $exception) {
            throw new OrderNotCancelledException($command->referenceId);
        }
    }

    /**
     * @return Client
     */
    private function getClient($client_id, $client_secret)
    {

        $reauth_client = new Client([
            // URL for access_token request
            'base_uri' => $this->apiBaseUrl.'oauth/token',
            'base_url' => $this->apiBaseUrl.'oauth/token'
        ]);

        $reauth_config = [
            "client_id" => $client_id,
            "client_secret" => $client_secret
        ];
        $grant_type = new ClientCredentials($reauth_client, $reauth_config);

        if (method_exists(\GuzzleHttp\ClientInterface::class, 'getDefaultOption')) {
            // Guzzle 5

            $oauth = new OAuth2Subscriber($grant_type);

            $this->accessToken = $oauth->getAccessToken();
            return new Client(
                [
                    'base_url' => $this->apiBaseUrl,
                    'base_uri' => $this->apiBaseUrl,
                    'defaults' => [
                        'headers' => [
                            'Authorization' => "Bearer {$this->accessToken}",
                            'Content-Type' => 'application/json'

                        ]
                    ],
                ]
            );

        } else {
            // Guzzle 6

            $oauth = new OAuth2Middleware($grant_type);
            $stack = HandlerStack::create();
            $stack->push($oauth);

            $client = new Client([
                'base_url' => $this->apiBaseUrl,
                'base_uri' => $this->apiBaseUrl,
                'handler' => $stack,
                'auth'    => 'oauth'
            ]);
            return $client;

        }

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
     * @param string $orderId
     * @return array
     * @throws BillieException
     */
    private function get($path, $orderId)
    {
        $client = $this->getClient($this->consumerKey, $this->consumerSecretKey);

        try {
            $response = $client->get($path.'/'.$orderId);

            return json_decode($response->getBody()->getContents(), true);
        } catch (ClientException $exception) {
            if ($exception->getCode() === 401) {
                throw new UserNotAuthorizedException();
            }

            if ($exception->getCode() === 404) {
                throw new OrderNotFoundException($orderId);
            }

            if ($exception->getCode() === 500) {
                throw new UnexceptedServerException();
            }
        }

        return [];
    }


    /**
     * @param string $path
     * @param array $data
     * @param string $method
     * @return array
     * @throws BillieException
     */
    private function request($path, $data, $method = 'POST')
    {
        $client = $this->getClient($this->consumerKey, $this->consumerSecretKey);
        try {
            if ($method === 'POST') {
                $response = $client->post($path, ['body' => json_encode($data)]);
            } elseif ($method === 'PATCH') {
                $response = $client->patch($path, ['body' => json_encode($data)]);
            } elseif ($method === 'PUT') {
                $response = $client->put($path, ['body' => json_encode($data)]);
            }
            return json_decode($response->getBody()->getContents(), true);
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
                throw new OrderNotFoundException(array_key_exists('order_id',$data)?$data['order_id']: null);
            }

            if ($exception->getCode() === 500) {
                throw new UnexceptedServerException();
            }
        }

        return [];
    }

    /**
     * @param $reason
     * @throws BillieException
     */
    private function throwOrderDeclinedException($reason)
    {
        switch (strtoupper($reason)) {
            case 'DEBTOR_ADDRESS':
                throw new DebtorAddressException();
                break;

            case 'DEBTOR_NOT_IDENTIFIED':
                throw new DebtorNotIdentifiedException();
                break;

            case 'RISK_POLICY':
                throw new RiskPolicyDeclinedException();
                break;

            case 'DEBTOR_LIMIT_EXCEEDED':
                throw new DebtorLimitExceededException();
                break;
            default:
                throw new UnexceptedServerException();
        }
    }
}
