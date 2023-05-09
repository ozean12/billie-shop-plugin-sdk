<?php
/*
 * Copyright (c) Billie GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

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
     */
    public function __construct($orderId, $httpCode, array $responseData = [], array $requestData = [])
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

    public function getBillieCode(): string
    {
        return 'ORDER_NOT_FOUND';
    }
}
