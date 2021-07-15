<?php

namespace Billie\Sdk\Exception;

class OrderNotFoundException extends GatewayException
{
    /**
     * @var string
     */
    private $orderId;

    /**
     * @param string $orderId
     * @param int    $httpCode
     * @param array  $responseData
     * @param array  $requestData
     */
    public function __construct($orderId, $httpCode, $responseData = [], $requestData = [])
    {
        parent::__construct(
            sprintf('The order with the reference id: %s does not exist.', $orderId),
            $httpCode,
            $responseData,
            $requestData
        );
        $this->orderId = $orderId;
    }

    /**
     * @return string
     */
    public function getOrderId()
    {
        return $this->orderId;
    }

    /**
     * @return string
     */
    public function getBillieCode()
    {
        return 'ORDER_NOT_FOUND';
    }
}
