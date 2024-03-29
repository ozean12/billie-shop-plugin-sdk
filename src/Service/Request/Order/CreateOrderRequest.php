<?php
/*
 * Copyright (c) Billie GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Billie\Sdk\Service\Request\Order;

use Billie\Sdk\Exception\InvalidResponseException;
use Billie\Sdk\Exception\OrderDecline\DebtorLimitExceededException;
use Billie\Sdk\Exception\OrderDecline\DebtorNotIdentifiedException;
use Billie\Sdk\Exception\OrderDecline\InvalidDebtorAddressException;
use Billie\Sdk\Exception\OrderDecline\OrderDeclinedException;
use Billie\Sdk\Exception\OrderDecline\RiskPolicyDeclinedException;
use Billie\Sdk\HttpClient\BillieClient;
use Billie\Sdk\Model\Order;
use Billie\Sdk\Model\Request\Order\CreateOrderRequestModel;
use Billie\Sdk\Service\Request\AbstractRequest;

/**
 * @see https://developers.billie.io/#operation/order_create
 *
 * @extends AbstractRequest<CreateOrderRequestModel, Order>
 */
class CreateOrderRequest extends AbstractRequest
{
    protected function getMethod($requestModel): string
    {
        return BillieClient::METHOD_POST;
    }

    protected function getPath($requestModel): string
    {
        return '/orders';
    }

    /**
     * @throws OrderDeclinedException
     */
    protected function processSuccess($requestModel, ?array $responseData = null): Order
    {
        if ($responseData === null || $responseData === []) {
            throw new InvalidResponseException('Got no response from gateway. A response was expected.');
        }

        $model = new Order($responseData);
        if ($requestModel instanceof CreateOrderRequestModel && $model->getDeclineReason()) {
            switch ($model->getDeclineReason()) {
                case Order::DECLINED_REASON_INVALID_ADDRESS:
                    $exception = new InvalidDebtorAddressException($requestModel, $model);
                    break;
                case Order::DECLINED_REASON_DEBTOR_NOT_IDENTIFIED:
                    $exception = new DebtorNotIdentifiedException($requestModel, $model);
                    break;
                case Order::DECLINED_REASON_RISK_POLICY:
                    $exception = new RiskPolicyDeclinedException($requestModel, $model);
                    break;
                case Order::DECLINED_REASON_DEBTOR_LIMIT_EXCEEDED:
                    $exception = new DebtorLimitExceededException($requestModel, $model);
                    break;
                default:
                    $exception = new OrderDeclinedException($requestModel, $model, 'Unknown rejection', strtoupper($model->getDeclineReason()));
                    break;
            }

            $this->processFailed($requestModel, $exception);
            throw $exception;
        }

        return $model;
    }
}
